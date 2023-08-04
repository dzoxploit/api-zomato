<?php

// app/Http/Controllers/ApiBaseController.php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiBaseController extends Controller
{
    protected function successResponse($data = null, $status = 200)
    {
        return response()->json([
            'data' => $data,
        ], $status);
    }

    protected function errorResponse($message, $status)
    {
        return response()->json([
            'error' => $message,
        ], $status);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $exception);
    }
}
