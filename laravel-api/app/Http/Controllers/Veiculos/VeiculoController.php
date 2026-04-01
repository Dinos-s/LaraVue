<?php

namespace App\Http\Controllers\Veiculos;

use App\Http\Controllers\Controller;
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
}
