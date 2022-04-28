<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chek;

use App\Http\Requests\ChekRequest;

class ChekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Chek::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChekRequest $request)
    {
        return Chek::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Chek::find($id) ? Chek::find($id) : ['error' => '404'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Chek  $chek
     * @return \Illuminate\Http\Response
     */
    public function update(ChekRequest $request, Chek  $chek)
    {
        $chek->update($request->all());
        return $chek;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Chek  $chek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chek  $chek)
    {
        return $chek->delete($chek);
    }
}
