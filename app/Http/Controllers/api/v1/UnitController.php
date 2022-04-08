<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Unit;
use App\Http\Requests\UnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Unit::where('active', true)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        $array = ['status' => 'created'];
        $array['unit'] = Unit::create($request->all());
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
        return Unit::where('active', true)->find($id) ? Unit::where('active', true)->find($id) : ['error' => '404'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $array = ['status' => 'updated'];
        $unit->update($request->all());
        $array['unit'] = $unit;
        return $array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit  $unit)
    {
        $array = ['status' => 'inactivated'];
        // $client->delete($client);
        Unit::where('id', $unit->id)->update(['active' => 0]);
        return $array;

    }
}
