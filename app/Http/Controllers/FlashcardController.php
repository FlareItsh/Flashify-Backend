<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Repositories\Contracts\FlashcardRepositoryInterface;
use App\Repositories\Contracts\CollectionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlashcardController extends Controller
{
    protected FlashcardRepositoryInterface $flashcardRepository;
    protected CollectionRepositoryInterface $collectionRepository;

    public function __construct(
        FlashcardRepositoryInterface $flashcardRepository,
        CollectionRepositoryInterface $collectionRepository
    ) {
        $this->flashcardRepository = $flashcardRepository;
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * Display a listing of flashcards for a collection.
     *
     * @param int $collectionId
     * @param Request $request
     * @return JsonResponse
     */
    public function index(int $collectionId, Request $request): JsonResponse
    {
        $collection = $this->collectionRepository->findById($collectionId);

        if (!$collection) {
            return response()->json([
                'status' => 'error',
                'message' => 'Collection not found'
            ], 404);
        }

        // Check if collection belongs to authenticated user
        if ($collection->user_id !== $request->user()->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to this collection'
            ], 403);
        }

        $perPage = $request->get('per_page', 15);
        $flashcards = $this->flashcardRepository->paginateByCollectionId($collectionId, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => $flashcards
        ]);
    }

    /**
     * Store a newly created flashcard.
     *
     * @param int $collectionId
     * @param Request $request
     * @return JsonResponse
     */
    public function store(int $collectionId, Request $request): JsonResponse
    {
        $collection = $this->collectionRepository->findById($collectionId);

        if (!$collection) {
            return response()->json([
                'status' => 'error',
                'message' => 'Collection not found'
            ], 404);
        }

        // Check if collection belongs to authenticated user
        if ($collection->user_id !== $request->user()->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to this collection'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'front' => 'required|string',
            'back' => 'required|string',
            'hint' => 'nullable|string',
            'explaination' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['collection_id'] = $collectionId;

        $flashcard = $this->flashcardRepository->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Flashcard created successfully',
            'data' => $flashcard
        ], 201);
    }

    /**
     * Display the specified flashcard.
     *
     * @param int $collectionId
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function show(int $collectionId, int $id, Request $request): JsonResponse
    {
        $collection = $this->collectionRepository->findById($collectionId);

        if (!$collection) {
            return response()->json([
                'status' => 'error',
                'message' => 'Collection not found'
            ], 404);
        }

        // Check if collection belongs to authenticated user
        if ($collection->user_id !== $request->user()->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to this collection'
            ], 403);
        }

        $flashcard = $this->flashcardRepository->findById($id);

        if (!$flashcard || $flashcard->collection_id !== $collectionId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Flashcard not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $flashcard
        ]);
    }

    /**
     * Update the specified flashcard.
     *
     * @param int $collectionId
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $collectionId, int $id, Request $request): JsonResponse
    {
        $collection = $this->collectionRepository->findById($collectionId);

        if (!$collection) {
            return response()->json([
                'status' => 'error',
                'message' => 'Collection not found'
            ], 404);
        }

        // Check if collection belongs to authenticated user
        if ($collection->user_id !== $request->user()->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to this collection'
            ], 403);
        }

        $flashcard = $this->flashcardRepository->findById($id);

        if (!$flashcard || $flashcard->collection_id !== $collectionId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Flashcard not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'front' => 'sometimes|string',
            'back' => 'sometimes|string',
            'hint' => 'nullable|string',
            'explaination' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $this->flashcardRepository->update($flashcard, $validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Flashcard updated successfully',
            'data' => $flashcard->fresh()
        ]);
    }

    /**
     * Remove the specified flashcard.
     *
     * @param int $collectionId
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $collectionId, int $id, Request $request): JsonResponse
    {
        $collection = $this->collectionRepository->findById($collectionId);

        if (!$collection) {
            return response()->json([
                'status' => 'error',
                'message' => 'Collection not found'
            ], 404);
        }

        // Check if collection belongs to authenticated user
        if ($collection->user_id !== $request->user()->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access to this collection'
            ], 403);
        }

        $flashcard = $this->flashcardRepository->findById($id);

        if (!$flashcard || $flashcard->collection_id !== $collectionId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Flashcard not found'
            ], 404);
        }

        $this->flashcardRepository->delete($flashcard);

        return response()->json([
            'status' => 'success',
            'message' => 'Flashcard deleted successfully'
        ]);
    }
}
