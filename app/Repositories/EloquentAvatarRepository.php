<?php

namespace App\Repositories;

use App\Models\Avatar;
use App\Repositories\Contracts\AvatarRepositoryInterface;

class EloquentAvatarRepository implements AvatarRepositoryInterface
{
    public function all()
    {
        return Avatar::all();
    }

    public function findById(int $id)
    {
        return Avatar::find($id);
    }

    public function create(array $data)
    {
        return Avatar::create($data);
    }

    public function update($avatar, array $data)
    {
        $avatar->update($data);
        return $avatar;
    }

    public function delete(int $id)
    {
        return Avatar::destroy($id);
    }
}