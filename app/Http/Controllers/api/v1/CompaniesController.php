<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompaniesRequest;
use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        $companies = Companies::all();
        return response()->json($companies);
    }

    public function show($id)
    {
        $Companies = Companies::find($id);
        if (!$Companies) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }
        return response()->json($Companies);
    }

    public function store(CompaniesRequest $request)
    {
        $Companies = Companies::create($request->all());
        return response()->json($Companies, 201);
    }



    public function update(CompaniesRequest $request, $id)
    {
        $Companies = Companies::find($id);
        if (!$Companies) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        $Companies->update($request->all());
        return response()->json($Companies);
    }


    public function destroy($id)
    {
        $Companies = Companies::find($id);
        if (!$Companies) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        $Companies->delete();
        return response()->json(['message' => 'Empresa removida com sucesso']);
    }


    // public function is_validate(Request $request)
    // {

    //     $company = Companies::where('id', $request->id)->first();

    //     //valida e checa usuario e password

    //     if (!$company || $request->password !== $company->master_password) {
    //         return response([
    //             'message' => 'Senha Inválida'
    //         ], 401);
    //     }

    //     return response(true, 201);
    // }
}
