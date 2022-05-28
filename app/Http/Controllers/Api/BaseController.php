<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
       * metodo com resposta de sucesso
    **/
    public function sendResponse($result, $message){

        $response = [
            'success'   => true,
            'data'      => $result,
            'message'   => $message,
        ];

        return response()->json($response, 200);
    }

    /**
       * metodo com resposta de erro
    **/
    public function sendError($error, $errorMessages = [], $code = 404){

        $response = [
            'success'   => false,
            'message'   => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}