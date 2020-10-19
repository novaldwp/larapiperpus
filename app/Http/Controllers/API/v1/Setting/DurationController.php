<?php

namespace App\Http\Controllers\API\v1\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Setting\Duration;
use App\Http\Controllers\API\v1\Setting\DurationController;
use App\Http\Resources\Setting\DurationResource;

class DurationController extends Controller
{
    public function index()
    {
        $duration = $this->getDuration();

        if(!$duration)
        {
            return $this->sendEmpty();
        }

        return $this->sendResponse(new DurationResource($duration), "Retrieve duration successfully");
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $duration = $this->getDuration();

        if ($duration)
        {
            return $this->update($request);
        }

        $duration = Duration::create([
            'duration' => $request->duration
        ]);

        return $this->sendResponse(new DurationResource($duration), 'Insert duration successfully');
    }

    public function update($request)
    {
        $duration = $this->getDuration();

        $duration->update([
            'duration' => $request->duration
        ]);

        return $this->sendResponse(new DurationResource($duration), 'Update duration successfully');
    }

    public function getDuration()
    {
        $duration = Duration::orderBy('id', 'DESC')->first();

        return $duration;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'duration' => 'required|integer'
        ]);
    }
}
