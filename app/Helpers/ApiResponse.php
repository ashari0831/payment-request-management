<?php

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponse
{
    public static function sendResponse($result, $message = '', $code = 200)
    {
        $response = [
            'success' => true,
            'data' => $result
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }

    public static function rollback($e, $message = "Something went wrong! Process not completed", $status = 500)
    {
        DB::rollBack();
        self::throw($e, $message, $status);
    }

    public static function throw($e, $message = "Something went wrong! Process not completed", $status = 500)
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(["message" => $message], $status));
    }
}
