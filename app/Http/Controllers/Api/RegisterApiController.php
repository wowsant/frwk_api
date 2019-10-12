<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Api\ExceptionApiController;


class RegisterApiController extends Controller
{
    public function register(Request $request) {
        try {
            if (User::checkDuplicityUser($request->get('email')) == 0) {
                return User::create([
                    'name'     => $request->get('name'),
                    'email'    => $request->get('email') ,
                    'password' => Hash::make($request->get('password')),
                ]);
            } else {
                return ExceptionApiController::error(
                    '500',
                    array('description' =>  'Ops... Email já cadastrado'),
                    'Não foi posivel realizar processo..'
                );
            }

        } catch (\Exeption $e) {
            return response()->json(['msg' => 'Ops... Email já cadastrado'], 500);
        }
    }
}
