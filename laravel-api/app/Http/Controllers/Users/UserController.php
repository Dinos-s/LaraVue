<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
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

    public function show($id): JsonResponse
    {
        try {

            $user = User::find($id);

            if (!$user) {

                Log::notice("Usuário não encontrado", ['user_id' => $id]);

                return response()->json([
                    'status' => false,
                    'message' => 'Usuário nao encontrado'
                ], 404);
            }

            Log::info("Usuário encontrado", ['user_id' => $id]);

            return response()->json([
                'status' => true,
                'user' => $user
            ], 200);

        } catch (\Exception $e) {

            Log::notice("Falha ao encontrar um usuário", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'falha ao encontrar o usuário'
            ], 400);
        }
    }

    public function store(UserRequest $request): JsonResponse
    {
        $valida = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8'
            ],
            [
                'name.required' => 'O campo nome deve ser preenchido',
                'email.required' => 'O campo email deve ser preenchido',
                'email.email' => 'O campo email deve ser um email',
                'email.unique' => 'O email informado ja existe',
                'password.required' => 'O campo senha deve ser preenchido',
                'password.confirmed' => 'As senhas não coecidem',
                'password.min' => 'O campo senha deve ter no minimo 8 caracteres'
            ]
        );

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            Log::info("Usuário criado", ['user_id' => $user->id]);

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário criado com sucesso'
            ], 201);
        } catch (\Exception $e) {
            Log::notice("Falha ao criar um usuário", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'falha ao criar um usuário'
            ], 400);
        }
    }

    public function update(User $user, UserRequest $request): JsonResponse
    {

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            Log::info("Usuário editado", ['user_id' => $user->id]);

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário editado com sucesso'
            ], 200);
        } catch (\Exception $e) {
            Log::notice("Falha ao editar um usuário", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'falha ao editar o usuário'
            ], 400);
        }
    }

    public function editPass(User $user, UserRequest $request): JsonResponse
    {

        try {
            $user->update([
                'password' => $request->password
            ]);

            Log::info("Senha do usuário editado", ['user_id' => $user->id]);

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Senha do usuário editada com sucesso'
            ], 200);
        } catch (\Exception $e) {
            Log::notice("Falha ao editar senha do usuário", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'falha ao editar a senha do usuário'
            ], 400);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();

            Log::info("Usuário deletado", ['user_id' => $user->id]);

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário deletado com sucesso'
            ], 200);
        } catch (\Exception $e) {
            Log::notice("Falha ao deletar um usuário", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'falha ao deletar o usuário'
            ], 400);
        }
    }
}
