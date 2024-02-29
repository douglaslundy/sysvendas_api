<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

use App\Http\Requests\CartRequest;
use App\Models\Product;
use App\Models\ProductStock;
use Exception;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cart::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        //    return Cart::create($request->all());
        $cart = $request->all();

        $estoque = ProductStock::where('id_product', $cart['id_product_stock'])->first();

        if (!$estoque)
            throw new Exception('Este produto não possui estoque cadastrado');

        $estoque->stock -= ($cart['qtd'] * floatval(str_replace(",", ".", $cart['reason'])));

        // throw new Exception($cart['qtd']);
        // throw new Exception("quantidade é " . $cart['qtd'] . " Razao é " . floatval(str_replace(",", ".", $cart['reason'])));

        //esse if proibe inserir um produto no carrinho em uma quantidade maior que disponivel em estoque
        // if (!$cart['qtd'] * $cart['reason'] > $estoque->stock )
        //     throw new Exception('Produto sem estoque para venda desejada');

        $estoque->save();

        $array = ['status' => 'created'];

        if (Cart::where('id_product', $cart['id_product'])->where('id_user', $cart['id_user'])->first()) {
            $existedCart = Cart::with(['product'])->where('id_product', $cart['id_product'])->where('id_user', $cart['id_user'])->first();
            $existedCart->qtd += $cart['qtd'];
            $existedCart->save();
            $array['cart'] = $existedCart;
            return $array;
        } else {
            $array['cart'] = Cart::create($cart);
            return $array;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\Response
     */
    public function show($id_user)
    {
        return Cart::with(['product'])->where('id_user', $id_user)->orderBy('id', 'asc')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CartRequest $request, $id)
    {
        if (!Cart::where('id', $id)->first())
            return ['status' => 'Este produto não existe no carrinho'];

        $estoque = ProductStock::where('id_product', $request['product']['id_product_stock'])->first();

        if (!$estoque)
            throw new Exception('Este produto não possui estoque cadastrado');

        $array = ['status' => 'updated'];
        $cart = Cart::with(['product'])->where('id', $id)->first();

        // throw new Exception($cart->qtd);
        // throw new Exception($cart['product']['reason']);
        // throw new Exception("quantidade atual é " . $cart['qtd'] . " Razao é " . $request['product']['reason'] . " a quantidade enviada é " . $request->input('qtd') );

        if ($cart->qtd > $request->input('qtd'))
            $estoque->stock += (($cart->qtd - $request->input('qtd')) * floatval(str_replace(",", ".", $request['product']['reason'])));

        if ($cart->qtd < $request->input('qtd'))
            $estoque->stock -= (($request->input('qtd') - $cart->qtd) * floatval(str_replace(",", ".", $request['product']['reason'])));


        $cart['qtd'] = $request->input('qtd');

        $cart['obs'] = $request->input('obs');

        $cart->save();
        $estoque->save();

        $array['cart'] = $cart;
        return $array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Cart::where('id', $id)->first())
            return ['status' => 'Este produto não existe no carrinho'];

        $cart = Cart::where('id', $id)->first();

        $product = Product::where('id', $cart->id_product)->first();

        $estoque = ProductStock::where('id_product', $product->id_product_stock)->first();

        if (!$estoque)
            throw new Exception('Este produto não possui estoque cadastrado');

        $estoque->stock += (($cart['qtd'] / 100) * $product->reason);
        $estoque->save();


        $array = ['status' => 'deleted'];
        $cart->delete();
        return $array;
    }

    public function cleanCartPerUser($id_user)
    {
        if (!Cart::where('id_user', $id_user)->first())
            return ['status' => 'este usuario não possui produtos no carrinho'];

        $array = ['status' => 'All deleted '];
        Cart::where('id_user', $id_user)->delete();
        return $array;
    }

    /**
     * Remove all products from storage.
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\Response
     */
    public function dropProductsPerUser($id_user)
    {
        if (!Cart::where('id_user', $id_user)->first())
            return ['status' => 'este usuario não possui produtos no carrinho'];

        $array = ['status' => 'All deleted '];
        Cart::where('id_user', $id_user)->delete();
        return $array;
    }
}
