<?php

namespace App\Repositories;

use App\Http\Requests\Profile\PasswordUpdateRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    use  ApiReturnFormatTrait, FileUploadTrait;

    private User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }



    public function list($request)
    {
        $data = $this->model->query()->with('image');

        $where = [];

        if ($request->search) {
            $where[] = ['name', 'like', '%' . $request->search . '%'];
        }

        if ($request->from && $request->to) {
            $data = $data->whereBetween('created_at', [Carbon::parse($request->from), Carbon::parse($request->to)->endOfDay()]);
        }

        $data = $data
            ->where($where)
            ->orderBy('id', 'DESC')
            ->paginate($request->show ?? 10);

        return $data;
    }


    public function store($request)
    {
        DB::beginTransaction();
        try {

            $userStore = new $this->model;
            $userStore->name = $request->name;
            $userStore->role_id = $request->role_id;
            $userStore->email = $request->email;
            $userStore->phone = $request->phone;
            $userStore->password = Hash::make($request->password);
            $userStore->status = $request->status;

            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'backend/uploads/users/profile_', [], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $userStore->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $userStore->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.user_created_successfully'),$userStore);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.user_created_failed'));
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $userUpdate = $this->model->findOrfail($id);
            $userUpdate->name = $request->name;
            $userUpdate->role_id = $request->role_id;
            $userUpdate->email = $request->email;
            $userUpdate->phone = $request->phone;
            if ($request->password) {
                $userUpdate->password = Hash::make($request->password);
            }
            $userUpdate->status = $request->status;

            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'backend/uploads/users/profile_', [], $userUpdate->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $userUpdate->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $userUpdate->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.user_updated_successfully'),$userUpdate);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }



    public function destroy($id)
    {
        try {

            $user = $this->model->find($id);
            $upload = $this->deleteFile($user->image_id, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }
            $user->delete();
            return $this->responseWithSuccess(___('alert.User_deleted_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function passwordUpdate(PasswordUpdateRequest $request, $id)
    {
        try {
            $userUpdate = $this->model->findOrfail($id);
            $userUpdate->password = Hash::make($request->password);
            $userUpdate->save();
            return $this->responseWithSuccess(___('alert.User password update successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    // instructor start

}
