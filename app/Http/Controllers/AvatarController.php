<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Repositories\Contracts\AvatarRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AvatarController extends Controller
{
    protected $avatarRepository;

    public function __construct(AvatarRepositoryInterface $avatarRepository)
    {
        $this->avatarRepository = $avatarRepository;
    }

    /**
     * Display a listing of avatars.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $avatars = $this->avatarRepository->all();

        return response()->json([
            'status' => 'success',
            'data' => $avatars
        ]);
    }
}