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

    public function sendDeleteSuccess($name)
    {
        $message = 'Delete '.$name.' successfully';
        $response = [
            'status' => 1,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    public function sendResponse($result, $type, $name)
    {
        switch($type)
        {
            case 1 :
                $operation = 'Retrieve';
            break;
            case 2 :
                $operation = 'Insert';
            break;
            case 3 :
                $operation = 'Update';
            break;
            case 0 :
                $operation = 'Get';
            break;
        }

        $message = $operation.' '.$name.' '.'Successfully';

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

    public function sendEmpty()
    {
        return response()->json([
            'status' => 1,
            'message' => 'No Data Available'
        ], 200);
    }

    public function sendError()
    {
        return response()->json([
            'status' => 0,
            'message' => 'Error one of your post data does not match on our records, please try again'
        ], 404);
    }

    public function sendErrorAmount()
    {
        return response()->json([
            'status' => 0,
            'mesage' => 'Inputed amount cannot be large than stock amount'
        ], 404);
    }

    public function sendInvalidStock()
    {
        return response()->json([
            'status' => 0,
            'message' => 'Inputed stock is invalid, please try again'
        ]);
    }

    public function sendAlreadyLoan()
    {
        return response()->json([
            'status' => 0,
            'message' => 'This member already loan a book, please return first'
        ]);
    }

    public function sendErrorUpload()
    {
        return response()->json([
            'status' => 0,
            'message' => 'Error occured when uploading file, please try again'
        ], 404);
    }
}
