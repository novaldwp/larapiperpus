<?php

namespace App\Http\Controllers\API\v1\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setting\Charge;
use App\Http\Resources\Setting\ChargeResource;

class ChargeController extends Controller
{
    public function index()
    {
        $charge = $this->getCharge();

        if (!$charge)
        {
            return $this->sendEmpty();
        }

        return $this->sendResponse(new ChargeResource($charge), 'Retrieve charge successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $charge = $this->getCharge();

        if($charge)
        {
            return $this->update($request);
        }

        $charge = Charge::create([
            'cost' => $request->cost
        ]);

        return $this->sendResponse(new ChargeResource($charge), 'Insert charge successfully');
    }

    public function update($request)
    {
        $charge = $this->getCharge();

        $charge->update([
            'cost' => $request->cost
        ]);

        return $this->sendResponse(new ChargeResource($charge), 'Update charge successfully');
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'cost' => 'required|integer'
        ]);
    }

    public function getCharge()
    {
        $charge = Charge::first();

        return $charge;
    }
}
