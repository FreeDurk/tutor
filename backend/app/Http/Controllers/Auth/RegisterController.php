<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct(protected UserRepository $userRepo) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        return $this->userRepo->create($request->validated());
    }
}
