<?php

namespace App\Http\Controllers\API\v1\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setting\Charge;
use App\Http\Resources\Setting\Charge\ChargeResource;

class ChargeController extends Controller
{
    public function index()
    {
        // fetch data dari getCharge()
        $charge = $this->getCharge();

        // cek kondisi
        if (!$charge)
        {
            // jika datanya kosong maka akan direturn sendEmpty()
            return $this->sendEmpty();
        }

        // jika datanya sudah ada akan direturn json resource
        return $this->sendResponse(new ChargeResource($charge), 1, 'Charge');
    }

    public function store(Request $request)
    {
        // validasi form request
        $this->__validate($request);

        // fetch data dari getCharge()
        $charge = $this->getCharge();

        // cek kondisi jika datanya ada
        if($charge)
        {
            // maka akan dijalankan update
            return $this->update($request);
        }

        // jika datanya tidak ada maka akan dibuat baru
        $charge = Charge::create([
            'cost' => $request->cost
        ]);

        // lalu direturn oleh json resource
        return $this->sendResponse(new ChargeResource($charge), 2, 'Charge');
    }

    public function update($request)
    {
        // fetch data dari getCharge()
        $charge = $this->getCharge();

        // update data yang di fetch tadi
        $charge->update([
            'cost' => $request->cost
        ]);

        // jika sudah maka akan direturn oleh json resource
        return $this->sendResponse(new ChargeResource($charge), 3, 'Charge');
    }

    public function __validate($request)
    {
        // validation rules
        return $this->validate($request, [
            'cost' => 'required|integer'
        ]);
    }

    public function getCharge()
    {
        // mengambil data dari model Charge dengan first()
        $charge = Charge::first();

        // return nilai $charge
        return $charge;
    }
}
