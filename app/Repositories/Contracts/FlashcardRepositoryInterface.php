<?php

namespace App\Repositories\Contracts;

use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Collection;

interface FlashcardRepositoryInterface
{
    /**
     * Create a new flashcard.
     *
     * @param array<string, mixed> $data
     * @return Flashcard
     */
    public function create(array $data): Flashcard;

    /**
     * Update an existing flashcard.
     *
     * @param Flashcard $flashcard
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(Flashcard $flashcard, array $data): bool;

    /**
     * Delete a flashcard.
     *
     * @param Flashcard $flashcard
     * @return bool
     */
    public function delete(Flashcard $flashcard): bool;

    /**
     * Find a flashcard by ID.
     *
     * @param int $id
     * @return Flashcard|null
     */
    public function findById(int $id): ?Flashcard;

    /**
     * Get all flashcards for a collection.
     *
     * @param int $collectionId
     * @return Collection
     */
    public function getByCollectionId(int $collectionId): Collection;

    /**
     * Get paginated flashcards for a collection.
     *
     * @param int $collectionId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateByCollectionId(int $collectionId, int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
