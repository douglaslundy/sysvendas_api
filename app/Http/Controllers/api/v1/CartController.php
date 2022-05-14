<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

use App\Http\Requests\CartRequest;

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
        $array = ['status' => 'created'];
        $array['cart'] = Cart::create($request->all());
        return $array;
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
        if(!Cart::where('id', $id)->first())
            return ['status' => 'Este produto não existe no carrinho'];

        $array = ['status' => 'updated'];
        $cart = Cart::where('id', $id)->first();
        $cart['qtd'] = $request->input('qtd');
        $cart->update();
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
        if(!Cart::where('id', $id)->first())
            return ['status' => 'Este produto não existe no carrinho'];

        $cart = Cart::where('id', $id)->first();
        $array = ['status' => 'deleted'];
        $cart->delete();
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
        if(!Cart::where('id_user', $id_user)->first())
            return ['status' => 'este usuario não possui produtos no carrinho'];

        $array = ['status' => 'All deleted '];
        Cart::where('id_user', $id_user)->delete();
        return $array;
    }
}
