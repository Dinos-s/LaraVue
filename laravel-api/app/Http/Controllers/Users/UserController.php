<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        Log::info("Listagem de Usuários");

        return response()->json([
            'status' => true,
            'users' => $users
        ], 200);
    }
}
