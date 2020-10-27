<?php

namespace App\Http\Controllers\API\v1\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transaction\Loan;
use App\Model\Setting\Duration;
use App\Http\Resources\Transaction\Loan\LoanResource;
use App\Http\Resources\Transaction\Loan\LoanCollection;
use Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loan = Loan::orderBy('id', 'DESC')
            ->has('book')
            ->has('member')
            ->has('user')
            ->orderBy('id', 'DESC')
            ->get();

        if($loan->isEmpty())
        {
            return $this->sendEmpty();
        }

        return $this->sendResponse(new LoanCollection($loan), 'Retrieve loan successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $member     = $this->getLoanByMemberId($request->member_id);
        $duration   = Duration::first()->duration;
        $return     = date('d-m-Y', strtotime("+".$duration." days"));

        if($member->isNotEmpty())
        {
            return $this->sendAlreadyLoan();
        }

        $loan = Loan::create([
            'code'      => $this->getCodeLoan(),
            'return'    => $return,
            'book_id'   => $request->book_id,
            'member_id' => $request->member_id,
            'user_id'   => Auth::id()
        ]);

        return $this->sendResponse(new LoanResource($loan), 'Insert loan successfully');
    }

    public function show($id)
    {
        $loan = $this->getLoanById($id);

        if (!$loan)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new LoanResource($loan), 'Get loan successfully');
    }

    public function destroy($id)
    {
        $loan = $this->getLoanById($id);

        if (!$loan)
        {
            return $this->sendNoData();
        }

        $loan->delete();

        return $this->sendSuccess("Delete loan successfully");
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'book_id'   => 'required|integer|exists:tm_book,id',
            'member_id' => 'required|integer|exists:tm_member,id',
        ]);
    }

    public function getCodeLoan()
    {
        $year   = date('y');
        $month  = date('m');
        $init   = "TRL";
        $format = $init.$year.$month;

        $loan   = Loan::withTrashed()
            ->where('code', 'like', $format.'%')
            ->count();

        if ($loan != 0)
        {
            $count = $loan + 1;
        }
        else {
            $count = 1;
        }

        $digit = sprintf("%03s", $count);
        $code  = $format.$digit;

        return $code;
    }

    public function getLoanById($id)
    {
        $loan = Loan::find($id);

        return $loan;
    }

    public function getLoanByMemberId($id)
    {
        $loan = Loan::withTrashed()
            ->where('member_id', $id)
            ->where('status', 0)
            ->get();

        return $loan;
    }
}
