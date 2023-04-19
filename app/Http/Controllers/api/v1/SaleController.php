<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Cart;
use App\Models\ItensOnSale;

use App\Http\Requests\SaleRequest;
use App\Models\Client;
use DateTime;
use Exception;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Sale::with(['itens', 'client'])->orderBy('id', 'desc')->get();
        $query =  Sale::query();

        if ($request->has('year')) {
            $query->whereYear('created_at', '=', $request->year);
        }
        if ($request->has('month')) {
            $query->whereMonth('created_at', '=', $request->month);
        }
        if ($request->has('day')) {
            $query->whereDay('created_at', '=', $request->day);
        }
        if ($request->has('date_begin')) {
            $query->whereDate('created_at', '>=', $request->date_begin);
        }
        if ($request->has('date_end')) {
            $query->whereDate('created_at', '<=', $request->date_end);
        }
        if ($request->has('date')) {
            $query->whereDate('created_at', '=', $request->date);
        }

        return $query->with(['itens', 'client'])->orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request)
    {
        $form = $request->all();

        // if ($form['type_sale'] == "in_cash") {
        //     $form['updated_at'] = new DateTime();
        // }

        $sale = Sale::create($form);

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

        if ($sale->type_sale == "on_term" && $sale->paied == "no")
            $this->updateDebitBalanceClient($sale->id_client, $sale->total_sale, $sale->discount);

        // $query =  Sale::query();
        return ([$this->dropProductsPerUser($sale->id_user), "sale" => [...Sale::query()->with(['itens', 'client'])->orderBy('id', 'desc')->where('id', $sale->id)->get()] ]);
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
        return ['error' => 'The sale don´t can updated'];
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

    public function updateDebitBalanceClient($id_client, $total_sale, $discount)
    {
        $client = Client::where('id', $id_client)->first();

        if (!$client)
            return ['status' => 'este usuario não possui produtos no carrinho'];

        $client->debit_balance += ($total_sale - $discount);
        return $client->update();
    }

    public function salesPerClient($id_client, $paied)
    {
        if ($paied == "all")
            return Sale::where('id_client', $id_client)->with(['itens', 'client'])->orderBy('id', 'desc')->get();

        return Sale::where('id_client', $id_client)->where('paied', $paied)->with(['itens', 'client'])->orderBy('id', 'desc')->get();
    }

    public function paySale(Request $request)
    {
        if ($request->id_sales) {

            $payClient = 0;
            $sales = 0;

            foreach ($request->id_sales as $id) {
                $sale = Sale::where('id', $id)->where('id_client', $request->id_client)->where('paied', 'no')->first();

                if ($sale) {
                    $sale->paied = "yes";
                    // $sale->pay_date = new DateTime();
                    $sale->update();
                    $payClient += ($sale->total_sale - $sale->discount);
                    $sales += 1;
                }
            }

            $client = Client::where('id', $request->id_client)->first();

            if ($client) {
                $client->debit_balance -= $payClient;
                $client->update();
            }

            return  "O pagamento de $sales vendas no total de R$ " . $payClient / 100 . " foi realizado com sucesso";
        } else {
            return "informe pelo menos uma venda";
        }
    }
}
