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
        // return Categorie::all();
        return  Categorie::where('active', true)->orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorieRequest $request)
    {
        $array = ['status' => 'created'];
        $array['categorie'] = Categorie::create($request->all());
        return $array;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Categorie::where('active', true)->find($id) ? Categorie::find($id) : ['error' => '404'];
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
        $array = ['status' => 'updated'];
        $categorie->update($request->all());
        $array['categorie'] = $categorie;
        return $array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        $array = ['status' => 'inactivated'];
        // $client->delete($client);
        Categorie::where('id', $categorie->id)->update(['active' => 0]);
        return $array;

    }
}
