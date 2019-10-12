<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExceptionApiController extends Controller
{
    static function error($cod_http, $data = array(), $msg ='') {
        switch ($cod_http) {
            case '406':
                return response()->json([
                    'return' => [
                        'msg' => 'Erro ao gravar informação, processo não realizado.',
                        'info' => !empty($msg) ? $msg : '',
                    ],
                    'invalid_data' => $data,
                ], 406);
                break;

            default:
                return response()->json([
                    'msg' => 'Erro ao gravar informação, processo não realizado',
                ], 500);
                break;
        }

    }
    static function success($data = array(), $msg ='') {

        return response()->json([
            'return' => [
                'msg' => 'Processo realizado com sucesso.',
                'info' => !empty($msg) ? $msg : '',
            ],
        ], 201);
    }
}
