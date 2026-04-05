<?php

namespace App\Http\Controllers\Veiculos;

use App\Http\Controllers\Controller;
use App\Http\Requests\VeiculoRequest;
use App\Models\Veiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VeiculoController extends Controller
{
    public function index(): JsonResponse
    {
        $veiculos = Veiculo::orderBy('id', 'desc')->paginate(10);

        Log::info("Listagem de Veículos");

        return response()->json([
            'status' => true,
            'veiculos' => $veiculos
        ], 200);
    }

    public function show($id): JsonResponse
    {
        try {

            $veiculo = Veiculo::find($id);

            if (!$veiculo) {

                Log::notice("Veiculo nao encontrado", ['veiculo_id' => $id]);

                return response()->json([
                    'status' => false,
                    'message' => 'Veículo não encontrado'
                ], 404);
            }

            Log::info("Veículo encontrado", ['veiculo_id' => $id]);

            return response()->json([
                'status' => true,
                'veiculo' => $veiculo
            ], 200);

        } catch (\Exception $e) {
            
            Log::notice("Falha ao encontrar um veiculo", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'falha ao encontrar o veiculo'
            ], 404);
        }
    }

    public function store(VeiculoRequest $request): JsonResponse
    {
        $valida = $request->validate([
            'model'=>'required',
            'year'=>'required|integer|digits:4|between:1900,3001'
        ],
        [
            'model.required'=>'Campo modelo é obrigatório',

            'year.required'=>'Campo ano é obrigatório',
            'year.integer'=>'O ano deve ser um número inteiro',
            'year.digits'=>'O ano deve ter 4 digitos',
            'year.between'=>'O ano deve estar entre 1900 e o ano atual'
        ]);

        try {

            $veiculo = Veiculo::create([
               "model" => $request->model,
               "year" => $request->year,
            ]);

            Log::info("Veículo criado", ['veiculo_id' => $veiculo->id]);

            return response()->json([
                'status' => true,
                'veiculo' => $veiculo,
                'message' => 'Veículo criado com sucesso'
            ], 201);
            
        } catch (\Exception $e) {
            Log::notice("Falha ao criar um novo veiculo",['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'falha ao criar um novo veiculo'
            ], 400);
        }
    }

    public function update(Veiculo $veiculo, VeiculoRequest $request): JsonResponse {

        try {

            $veiculo = Veiculo::find($veiculo->id);

            if (!$veiculo) {
                return response()->json([
                    'status' => false,
                    'message' => 'Veículo não encontrado'
                ], 404);
            }

            $veiculo->update([
                'model'=>$request->model,
                'year'=>$request->year
            ]);

            Log::info("Veículo editado", ['veiculo_id' => $veiculo->id]);

            return response()->json([
                'status' => true,
                'veiculo' => $veiculo,
                'message' => 'Veículo editado com sucesso'
            ], 200);

        } catch (\Exception $e) {
            Log::notice("Falha ao editar um Veículo",['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'falha ao editar o Veículo'
            ], 400);
        }
    }

    public function destroy(Veiculo $veiculo): JsonResponse
    {
        try {
            $veiculo->delete();

            Log::info("Veículo deletado", ['veiculo_id' => $veiculo->id]);

            return response()->json([
                'status' => true,
                'veiculo' => $veiculo,
                'message' => 'Veículo deletado com sucesso'
            ], 200);
        } catch (\Exception $e) {
            Log::notice("Falha ao deletar um usuário",['error' => $e->getMessage()]);            

            return response()->json([
                'status' => false,
                'message' => 'falha ao deletar o usuário'
            ]);
        }
    }
}
