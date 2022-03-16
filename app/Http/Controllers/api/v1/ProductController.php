<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Product::where('active', true)->orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $array = ['status' => 'created'];
        $array['product'] = Product::create($request->all());
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
        return Product::where('active', true)->find($id) ? Product::find($id) : ['error' => '404'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product  $product)
    {
        $array = ['status' => 'updated'];
        $product->update($request->all());
        $array['product'] = $product;
        return $array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product  $product)
    {

        $array = ['status' => 'inactivated'];
        Product::where('id', $product->id)->update(['active' => 0]);
        return $array;
    }
}
