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

        return $this->sendResponse(new ReturnCollection($return), 'Retrieve return successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $loan = new LoanController;
        $loan = $loan->getLoanById($request->loan_id);

        if (!$loan)
        {
            return $this->sendNoData();
        }

        $late = $this->getLateReturn($loan->return);

        $return = TReturn::create([
            'loan_id'   => $request->loan_id,
            'late_day'  => $late['diff'],
            'charge'    => $late['charge'],
            'user_id'   => Auth::id()
        ]);

        return $this->sendResponse(new ReturnResource($return), 'Insert return successfully');
    }

    public function show($id)
    {
        $return = $this->getReturnById($id);

        if($return->isEmpty())
        {
            return $this->sendEmpty();
        }

        return $this->sendResponse(new ReturnResource($return), 'Get return successfully');
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
            ->with(['loan'])
            ->Wherehas('loan', function($q) {
                $q->has('book.publisher');
                $q->has('book.author');
                $q->has('book.category');
            })
            ->get();

        return $return;
    }

    public function getLateReturn($date)
    {
        $date1  = new \DateTime(date('Y-m-d'));
        $date2  = new \DateTime($date);
        $diff   = 0;
        $res    = [];

        if ($date1 > $date2)
        {
            $diff = $date2->diff($date1)->format("%d");
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
