<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param array<string, mixed> $data
     * @return User
     */
    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return User::create($data);
    }

    /**
     * Update an existing user.
     *
     * @param User $user
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(User $user, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $user->update($data);
    }

    /**
     * Delete a user.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::with('avatar')->find($id);
    }

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::with('avatar')->where('email', $email)->first();
    }

    /**
     * Find a user by username.
     *
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username): ?User
    {
        return User::with('avatar')->where('username', $username)->first();
    }

    /**
     * Get all users.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return User::with('avatar')->get();
    }

    /**
     * Get paginated users.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::with('avatar')->paginate($perPage);
    }
}
