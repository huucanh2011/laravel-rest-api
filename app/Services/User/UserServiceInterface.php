<?php

namespace App\Services\User;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function filter(Request $request);

    public function store(CreateUserRequest $request);

    public function getById(string $id);

    public function update(UpdateUserRequest $request, string $id);

    public function destroy(string $id);
}
