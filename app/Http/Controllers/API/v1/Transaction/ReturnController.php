<?php

namespace App\Http\Controllers\API\v1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\Transaction\LoanController;
use App\Http\Controllers\API\v1\Setting\ChargeController;
use App\Http\Controllers\API\v1\Setting\DurationController;
use Illuminate\Http\Request;
use App\Model\Transaction\TReturn;
use App\Http\Resources\Transaction\TReturn\ReturnResource;
use App\Http\Resources\Transaction\TReturn\ReturnCollection;
use Auth;
use Carbon\Carbon;

class ReturnController extends Controller
{
    public function index()
    {
        $return = TReturn::with(['loan', 'user'])
            ->orderBy('id', 'DESC')
            ->get();

        if($return->isEmpty())
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new ReturnCollection($return), 1, 'Return');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $loan   = new LoanController;
        $loan   = $loan->getLoanById($request->loan_id);
        $return = TReturn::where('loan_id', $loan->id)->first();

        if (!$loan)
        {
            return $this->sendNoData();
        }

        if ($return)
        {
            return $this->sendAlreadyReturn();
        }

        $late = $this->getLateReturn($loan->return);

        $return = TReturn::create([
            'loan_id'   => $request->loan_id,
            'late_day'  => $late['diff'],
            'charge'    => $late['charge'],
            'user_id'   => Auth::id()
        ]);

        $loan->status = '0';
        $loan->save();

        return $this->sendResponse(new ReturnResource($return), 2, 'Return');
    }

    public function show($id)
    {
        $return = $this->getReturnById($id);

        if(empty($return))
        {
            return $this->sendEmpty();
        }

        return $this->sendResponse(new ReturnResource($return), 0, 'Return');
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'loan_id' => 'required|integer|exists:tp_loan,id'
        ]);
    }

    public function getReturnById($id)
    {
        $return = TReturn::where('id', $id)
            ->with(['loan', 'loan.book'])
            ->whereHas('loan', function($q) {
                $q->has('book.publisher');
                $q->has('book.author');
                $q->has('book.category');
            })
            ->first();

        return $return;
    }

    public function getLateReturn($date)
    {
        $date1 = Carbon::parse(Carbon::now());
        $diff   = 0;
        $res    = [];

        if ($date1 > $date)
        {
            $diff = $date1->diffInDays($date);
        }

        $charge = $this->getChargeReturn($diff);
        $res    = [
            'diff'      => $diff,
            'charge'    => $charge
        ];

        return $res;
    }

    public function getChargeReturn($diff)
    {
        $charge = new ChargeController;
        $charge = $charge->getCharge()->cost;

        $cost   = $diff * $charge;

        return $cost;
    }
}
