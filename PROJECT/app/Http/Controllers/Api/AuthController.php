<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Events\ForgotPasswordEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\SignInRequest;
use App\Http\Requests\Api\SignUpRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;


class AuthController extends Controller
{
    use ApiReturnFormatTrait;

    protected $user;

    public function __construct(User $user)
    {
        $this->user             = $user;
    }



    public function registration(SignUpRequest $request)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $user               =   new $this->user;
            $user->name         =   $request->name;
            $user->email        =   $request->email ?? '';
            $user->phone        =   $request->phone ?? '';
            $user->password     =   Hash::make($request->password);
            $user->role_id      =   $request->role_id ?? 0;
            if ($user->save()) {
                $data['user']   = $user;
                $data['token']  = $user->createToken('auth_token')->plainTextToken;

                DB::commit();
                return $this->responseWithSuccess(___('alert.User has been registered successfully.'), $data);
            }
        }

        catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response

        }
    }

    public function login(SignInRequest $request)
    {

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                $user   = new UserResource($this->user->where('email', $request->email)->first());
                $data['user']   = $user;
                $data['token']  = $user->createToken('auth_token')->plainTextToken;

                return $this->responseWithSuccess(___('alert.successfully Logged in'), $data);
            }

            return $this->responseWithError(___('alert.Invalid login details'), [], 400); // return error response

        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response

        }
    }

}
