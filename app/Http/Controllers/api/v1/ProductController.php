<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductStock;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Product::with(['stock'])->with(['category'])->with(['unity'])->where('active', true)->orderBy('name', 'asc')->get();
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
        $product = Product::create($request->all());
        $product = Product::find($product->id);

        $stock = new ProductStock();
        $stock->id_product = $product->id;
        $stock->stock = $request->input('stock');
        $stock->save();
        $product['stock'] = $request->input('stock');

        $product['category'] = $product->category;
        $product['unity'] = $product->unity;
        $array['product'] = $product;
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
        if (!Product::where('active', true)->find($id))
            return ['error' => '404'];

        $prod = Product::with(['stock'])->with(['unity'])->with(['category'])->find($id);
        return $prod;
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
        $product = Product::find($product->id);

        $stock = ProductStock::where('id_product', $product->id)->first();
        if ($stock) {
            $stock->id_product = $product->id;
            $stock->stock = $request->input('stock');
            $stock->update();
        } else {
            $stock = new ProductStock();
            $stock->id_product = $product->id;
            $stock->stock = $request->input('stock');
            $stock->save();
        }

        $product['stock'] = $request->input('stock');
        $product['category'] = $product->category;
        $product['unity'] = $product->unity;

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateValueCategories(Request $request)
    {
        if (!Product::where('active', true)->where('id_category', $request->id_category)->first())
            throw new Exception('Categoria não encontrada');

        if (!$request->percent)
            throw new Exception('Valor percentual não informado ou inválido');

        $array = ['status' => 'Preço dos produtos desta categoria foram atualizados com Sucesso'];
        $data =  Product::where('active', true)->where('id_category', $request->id_category)->get();

        foreach ($data as $prod) {
            $prod['sale_value'] = ($prod->sale_value + ($prod->sale_value * ($request->percent / 100)));
            $prod->update();
        }
        return $array;
    }
}
