<?php

namespace App\Repositories\User;

use App\Constants;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $modelName = User::class;

    protected $orderOptions = [
        'id',
        'email',
        'created_at',
        'updated_at',
    ];

    public function filter(Request $request)
    {
        $this->resolveOrder('id');
        $pageSize = request('page_size', Constants::PAGE_SIZE_DEFAULT);
        $filters = $request->only(['keyword', 'role']);
        $data = $this->paginate('id', [], $pageSize, $filters);

        return UserResource::collection($data);
    }

    protected function applyFilters(Builder $instance, array $filters = []): void
    {
        foreach (Arr::except($filters, ['keyword']) as $key => $value) {
            $instance->where($key, $value);
        }
        if (isset($filters['keyword'])) {
            $instance->whereLike(['name', 'email'], $filters['keyword']);
        }
        // $instance->isAdmin();
    }
}
