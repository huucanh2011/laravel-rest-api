<?php

namespace App\Services\User;

use App\ApiCode;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface
{
    use ResponseApi;

    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function filter(Request $request)
    {
        return $this->userRepository->filter($request);
    }

    public function store(CreateUserRequest $request)
    {
        $data = $this->userRepository->store($request->validated());

        return $this->respond($data, 'Created');
    }

    public function getById(string $id)
    {
        $data = $this->userRepository->findOrFail($id);
        if (is_null($data)) {
            return $this->respondNotFound(ApiCode::RESOURCE_NOT_FOUND);
        }

        return $this->respond(UserResource::make($data));
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $this->userRepository->update($id, $request->validated());
        if (is_null($data)) {
            return $this->respondNotFound(ApiCode::RESOURCE_NOT_FOUND);
        }

        return $this->respond($data, 'Updated');
    }

    public function destroy(string $id)
    {
        $data = $this->userRepository->destroy($id);
        if (is_null($data)) {
            return $this->respondNotFound(ApiCode::RESOURCE_NOT_FOUND);
        }

        return $this->respondWithMessage('Deleted');
    }
}
