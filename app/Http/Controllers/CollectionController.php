<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Repositories\Contracts\CollectionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    protected CollectionRepositoryInterface $collectionRepository;

    public function __construct(CollectionRepositoryInterface $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * Display a listing of collections for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $collections = $this->collectionRepository->paginateByUserId($request->user()->user_id, $perPage);
        $stats = $this->collectionRepository->getUserStats($request->user()->user_id);

        return response()->json([
            'status' => 'success',
            'data' => $collections,
            'stats' => $stats
        ]);
    }

    /**
     * Store a newly created collection.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|array',
            'priority_level' => 'nullable|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = $request->user()->user_id;

        $collection = $this->collectionRepository->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Collection created successfully',
            'data' => $collection->load('flashcards')
        ], 201);
    }

    /**
     * Display the specified collection.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        $collection = $this->collectionRepository->findById($id);

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

        // Update last_studied_at timestamp
        $collection->update(['last_studied_at' => now()]);

        return response()->json([
            'status' => 'success',
            'data' => $collection->fresh()
        ]);
    }

    /**
     * Update the specified collection.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $collection = $this->collectionRepository->findById($id);

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
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|array',
            'priority_level' => 'sometimes|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $this->collectionRepository->update($collection, $validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Collection updated successfully',
            'data' => $collection->fresh()->load('flashcards')
        ]);
    }

    /**
     * Remove the specified collection.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        $collection = $this->collectionRepository->findById($id);

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

        $this->collectionRepository->delete($collection);

        return response()->json([
            'status' => 'success',
            'message' => 'Collection deleted successfully'
        ]);
    }
}
