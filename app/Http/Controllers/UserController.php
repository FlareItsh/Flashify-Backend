<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $users = $this->userRepository->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    /**
     * Store a newly created user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar_id' => 'nullable|exists:avatars,avatar_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Assign random avatar if not provided
        if (!isset($data['avatar_id']) || $data['avatar_id'] === null) {
            $avatarCount = \App\Models\Avatar::count();
            if ($avatarCount > 0) {
                $data['avatar_id'] = \App\Models\Avatar::inRandomOrder()->first()->avatar_id;
            }
        }

        $user = $this->userRepository->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user->load('avatar')
        ], 201);
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user->load(['avatar', 'collections'])
        ]);
    }

    /**
     * Update the specified user.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => ['sometimes', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'password' => 'sometimes|string|min:8|confirmed',
            'avatar_id' => 'nullable|exists:avatars,avatar_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $this->userRepository->update($user, $validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user->fresh()->load('avatar')
        ]);
    }

    /**
     * Remove the specified user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $this->userRepository->delete($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Get user by username.
     *
     * @param string $username
     * @return JsonResponse
     */
    public function getByUsername(string $username): JsonResponse
    {
        $user = $this->userRepository->findByUsername($username);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user->load(['avatar', 'collections'])
        ]);
    }

    /**
     * Get user by email.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $this->userRepository->findByEmail($request->email);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user->load(['avatar', 'collections'])
        ]);
    }
}
