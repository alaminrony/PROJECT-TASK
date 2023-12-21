<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\UserInterface;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;


class UserController extends Controller
{
    use ApiReturnFormatTrait;

    private $user;

    public function __construct(UserInterface $userInterface)
    {
        $this->user = $userInterface;
    }

    public function index(Request $request)
    {
        $data['users'] = $this->user->list($request);

        return $this->responseWithSuccess(___('user.data found'), $data);
    }



    public function store(UserStoreRequest $request)
    {

        try {
            $result = $this->user->store($request);

            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'],$result->original['data']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        // dd($id);
        try {
            $result = $this->user->update($request, $id);
            if ($result->original['result']) {
              return $this->responseWithSuccess($result->original['message'],$result->original['data']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function delete($id)
    {
        try {

            $result = $this->user->destroy($id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }



    public function status(Request $request)
    {

        if ($request->type == 'active') {
            $request->merge([
                'status' => 1,
            ]);
            $this->user->status($request);
        }

        if ($request->type == 'inactive') {
            $request->merge([
                'status' => 0,
            ]);
            $this->user->status($request);
        }

        return response()->json(["message" => __("Status update successful")], Response::HTTP_OK);
    }


}
