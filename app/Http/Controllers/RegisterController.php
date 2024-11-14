<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError(
                'Validation Error.',
                404,
                $validator->errors()->toArray()
            );
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        $success['message'] = 'User register successfully.';

        return $this->sendResponse($success);
    }

    /**
     * Login api
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success);

        } else {
            return $this->sendError(
                'Unauthorised.',
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
