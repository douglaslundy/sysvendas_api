<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Categorie;
use App\Http\Requests\CategorieRequest;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Categorie::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorieRequest $request)
    {
        return Categorie::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Categorie::find($id) ? Categorie::find($id) : ['error' => '404'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(CategorieRequest $request, Categorie  $categorie)
    {
       $categorie->update($request->all());
       return $categorie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        return $categorie->delete($categorie);
    }
}
