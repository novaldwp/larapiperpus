<?php

namespace App\Http\Controllers\API\v1\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setting\Duration;
use App\Http\Resources\Setting\Duration\DurationResource;

class DurationController extends Controller
{
    public function index()
    {
        // fetch data duration pakai getDuration()
        $duration = $this->getDuration();

        // cek kondisi jika data kosong
        if(!$duration)
        {
            // maka akan direturn sendEmpty()
            return $this->sendEmpty();
        }

        // jika data tersedia maka akan direturn oleh json resource
        return $this->sendResponse(new DurationResource($duration), 1, "Duration");
    }

    public function store(Request $request)
    {
        // validasi form request
        $this->__validate($request);

        // fetch data duration pakai getDuration()
        $duration = $this->getDuration();

        // cek kondisi jika data tersedia
        if ($duration)
        {
            // maka dialihkan ke fungsi update
            return $this->update($request);
        }

        // jika data tidak tersedia maka akan mengcreate data baru
        $duration = Duration::create([
            'duration' => $request->duration
        ]);

        // jika sudah di create akan di return oleh json resource
        return $this->sendResponse(new DurationResource($duration), 2,  'Duration');
    }

    public function update($request)
    {
        // fetch data duration pakai getDuration()
        $duration = $this->getDuration();

        // jalankan fungsi update pada data yang di fetch tadi
        $duration->update([
            'duration' => $request->duration
        ]);

        // jika selesai akan di return oleh json resource
        return $this->sendResponse(new DurationResource($duration), 3, 'Duration');
    }

    public function getDuration()
    {
        // eloquent untuk memanggil data yang pertama pada model Duration
        $duration = Duration::first();

        // mengembalikan nilai $duration
        return $duration;
    }

    public function __validate($request)
    {
        // validation rules
        return $this->validate($request, [
            'duration' => 'required|integer'
        ]);
    }
}
