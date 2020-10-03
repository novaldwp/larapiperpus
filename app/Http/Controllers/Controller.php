<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendSuccess($message)
    {
        $response = [
            'status' => 1,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'status' => 1,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, 200);
    }

    public function sendNoData()
    {
        return response()->json([
            'status' => 0,
            'message' => 'Data does not match on our records, please try again'
        ], 404);
    }
}
