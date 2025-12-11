<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param array<string, mixed> $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Update an existing user.
     *
     * @param User $user
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(User $user, array $data): bool;

    /**
     * Delete a user.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool;

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find a user by username.
     *
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username): ?User;

    /**
     * Get all users.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get paginated users.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
