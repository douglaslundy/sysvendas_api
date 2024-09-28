<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

use App\Models\ErrorLog;

class ErrorLogController extends Controller
{
    public function index()
    {
        // Retorna os logs de erro ordenados por ID em ordem decrescente, limitando a 3000 registros
        return ErrorLog::with(['user'])
            ->orderBy('id', 'desc')
            ->where('user_id', '!=', 1)
            ->take(3000)
            ->get();
    }
}
