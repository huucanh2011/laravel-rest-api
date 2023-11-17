<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepositoryInterface;
use Illuminate\Http\Request;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function filter(Request $request);
}
