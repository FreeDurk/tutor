<?php

namespace App\Repositories;

use App\Http\ApiResponse\ApiResponse;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserRepository extends BaseRepository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $data = [])
    {
        try {
            DB::beginTransaction();
            $user = $this->model->create($data);

            DB::commit();

            return ApiResponse::success(new UserResource($user));
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function login($email, $password)
    {
        $user = $this->model->where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return ApiResponse::error('Invalid Credentials');
        }

        $token = $user->createToken('api_token', ['*'])->plainTextToken;

        $response = [
            'token_type' => 'bearer',
            'access_token' =>  $token,
            'user' => new UserResource($user)
        ];

        return ApiResponse::success($response);
    }
}
