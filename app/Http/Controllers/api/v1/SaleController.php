<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Cart;
use App\Models\ItensOnSale;

use App\Http\Requests\SaleRequest;
use App\Models\Client;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Sale::all();
        return Sale::with(['itens'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request)
    {
        $sale = Sale::create($request->all());

        $Products = Cart::where('id_user', $request->id_user)->get();

        foreach ($Products as $product) {
            $item = new ItensOnSale();
            $item->id_sale = $sale->id;
            $item->id_user = $sale->id_user;
            $item->id_product = $product->id_product;
            $item->qtd = $product->qtd;
            $item->item_value = $product->sale_value;
            $item->save();
        }

        if ($sale->type_sale == "on_term")
            $this->updateDebitBalanceClient($sale->id_client, $sale->total_sale);

        return $this->dropProductsPerUser($sale->id_user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Sale::find($id) ? Sale::find($id) : ['error' => '404'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaleRequest $request, $id)
    {
        return ['error' => 'The sale don´t can upudated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale  $sale)
    {
        return $sale->delete($sale);
    }



    public function dropProductsPerUser($id_user)
    {
        if (!Cart::where('id_user', $id_user)->first())
            return ['status' => 'este usuario não possui produtos no carrinho'];

        return Cart::where('id_user', $id_user)->delete();
    }

    public function updateDebitBalanceClient($id_client, $value)
    {
        $client = Client::where('id', $id_client)->first();

        if (!$client)
            return ['status' => 'este usuario não possui produtos no carrinho'];

        $client->debit_balance += $value;
        return $client->update();
    }
}
