<?php

namespace App\Repositories\Contracts;

interface AvatarRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function create(array $data);
    public function update($avatar, array $data);
    public function delete(int $id);
}