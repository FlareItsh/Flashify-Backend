<?php

namespace App\Repositories;

use App\Models\Flashcard;
use App\Repositories\Contracts\FlashcardRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentFlashcardRepository implements FlashcardRepositoryInterface
{
    /**
     * Create a new flashcard.
     *
     * @param array<string, mixed> $data
     * @return Flashcard
     */
    public function create(array $data): Flashcard
    {
        return Flashcard::create($data);
    }

    /**
     * Update an existing flashcard.
     *
     * @param Flashcard $flashcard
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(Flashcard $flashcard, array $data): bool
    {
        return $flashcard->update($data);
    }

    /**
     * Delete a flashcard.
     *
     * @param Flashcard $flashcard
     * @return bool
     */
    public function delete(Flashcard $flashcard): bool
    {
        return $flashcard->delete();
    }

    /**
     * Find a flashcard by ID.
     *
     * @param int $id
     * @return Flashcard|null
     */
    public function findById(int $id): ?Flashcard
    {
        return Flashcard::with('collection')->find($id);
    }

    /**
     * Get all flashcards for a collection.
     *
     * @param int $collectionId
     * @return Collection
     */
    public function getByCollectionId(int $collectionId): Collection
    {
        return Flashcard::where('collection_id', $collectionId)->get();
    }

    /**
     * Get paginated flashcards for a collection.
     *
     * @param int $collectionId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateByCollectionId(int $collectionId, int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Flashcard::where('collection_id', $collectionId)->paginate($perPage);
    }
}
