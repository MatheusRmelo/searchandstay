<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success($result = null, string $message = 'Sucesso') : JsonResponse
    {
        return response()->json([
            'message' => $message,
            'ok' => true,
            'result' => $result
        ]);
    }

    protected function create($result = null, string $message = 'Criado') : JsonResponse
    {
        return response()->json([
            'message' => $message,
            'ok' => true,
            'result' => $result
        ], 201);
    }

    protected function unauthorized($result = null, string $message = 'Não autorizado') : JsonResponse
    {
        return response()->json([
            'ok' => false,
            'result' => $result,
            'message' => $message,
        ], 401);
    }

    protected function forbidden($result = null, string $message = 'Proibido') : JsonResponse
    {
        return response()->json([
            'ok' => false,
            'result' => $result,
            'message' => $message,
        ], 403);
    }

    protected function notFound($result = null, string $message = 'Não encontrado') : JsonResponse
    {
        return response()->json([
            'ok' => false,
            'result' => $result,
            'message' => $message,
        ], 404);
    }
}
