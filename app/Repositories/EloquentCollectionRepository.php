<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Repositories\Contracts\CollectionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class EloquentCollectionRepository implements CollectionRepositoryInterface
{
    /**
     * Create a new collection.
     *
     * @param array<string, mixed> $data
     * @return Collection
     */
    public function create(array $data): Collection
    {
        return Collection::create($data);
    }

    /**
     * Update an existing collection.
     *
     * @param Collection $collection
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(Collection $collection, array $data): bool
    {
        return $collection->update($data);
    }

    /**
     * Delete a collection.
     *
     * @param Collection $collection
     * @return bool
     */
    public function delete(Collection $collection): bool
    {
        return $collection->delete();
    }

    /**
     * Find a collection by ID.
     *
     * @param int $id
     * @return Collection|null
     */
    public function findById(int $id): ?Collection
    {
        return Collection::with(['flashcards', 'user'])->find($id);
    }

    /**
     * Get all collections for a user.
     *
     * @param int $userId
     * @return EloquentCollection
     */
    public function getByUserId(int $userId): EloquentCollection
    {
        return Collection::where('user_id', $userId)->with('flashcards')->get();
    }

    /**
     * Get paginated collections for a user.
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateByUserId(int $userId, int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Collection::where('user_id', $userId)->with('flashcards')->paginate($perPage);
    }

    /**
     * Get user statistics (collection count and flashcard count).
     *
     * @param int $userId
     * @return array<string, int>
     */
    public function getUserStats(int $userId): array
    {
        $collectionsCount = Collection::where('user_id', $userId)->count();

        $flashcardsCount = Collection::where('user_id', $userId)
            ->withCount('flashcards')
            ->get()
            ->sum('flashcards_count');

        return [
            'collections_count' => $collectionsCount,
            'flashcards_count' => $flashcardsCount,
        ];
    }
}
