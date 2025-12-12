<?php

namespace App\Repositories\Contracts;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface CollectionRepositoryInterface
{
    /**
     * Create a new collection.
     *
     * @param array<string, mixed> $data
     * @return Collection
     */
    public function create(array $data): Collection;

    /**
     * Update an existing collection.
     *
     * @param Collection $collection
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(Collection $collection, array $data): bool;

    /**
     * Delete a collection.
     *
     * @param Collection $collection
     * @return bool
     */
    public function delete(Collection $collection): bool;

    /**
     * Find a collection by ID.
     *
     * @param int $id
     * @return Collection|null
     */
    public function findById(int $id): ?Collection;

    /**
     * Get all collections for a user.
     *
     * @param int $userId
     * @return EloquentCollection
     */
    public function getByUserId(int $userId): EloquentCollection;

    /**
     * Get paginated collections for a user.
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateByUserId(int $userId, int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * Get user statistics (collection count and flashcard count).
     *
     * @param int $userId
     * @return array<string, int>
     */
    public function getUserStats(int $userId): array;
}
