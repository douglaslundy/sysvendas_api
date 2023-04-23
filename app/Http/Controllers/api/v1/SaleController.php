<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Cart;
use App\Models\ItensOnSale;

use App\Http\Requests\SaleRequest;
use App\Models\Client;
use Exception;
use Illuminate\Support\Facades\DB;

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

        if ($form['type_sale'] == "on_term")
            $form['paied'] = 'no';

        if ($form['type_sale'] == "on_term" && $form['paied'] !== "no")
            throw new Exception('Ocorreu um erro nesta transação, por favor verifique se a mesma foi concluída, se não tente novamente, ou fale com suporte.');

        $sale = null;

        // a variavel $sale abaixo inserida dentro do metodo transaction Sem o operador &, a variável $sale dentro da função anônima seria uma cópia da variável original,
        //  e quaisquer alterações feitas dentro da função não seriam refletidas fora dela.

        DB::transaction(function () use ($form, $request, &$sale) {
            $sale = Sale::create($form);

            $products = Cart::where('id_user', $request->id_user)->get();

            foreach ($products as $product) {
                $item = new ItensOnSale();
                $item->id_sale = $sale->id;
                $item->id_user = $sale->id_user;
                $item->id_product = $product->id_product;
                $item->qtd = $product->qtd;
                $item->item_value = $product->sale_value;
                $item->save();
            }

            if ($sale->type_sale == "on_term" && $sale->paied == "no") {
                $this->updateDebitBalanceClient($sale->id_client, $sale->total_sale, $sale->discount);
            }

            $this->dropProductsPerUser($sale->id_user);
        }, 5);

        return [
            "sale" => Sale::with(['itens', 'client'])->orderBy('id', 'desc')->where('id', $sale->id)->get()
        ];
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
        // return $sale->delete($sale);
        return ['error' => 'The sale don´t can deleted'];
    }



    public function dropProductsPerUser($id_user)
    {
        if (!Cart::where('id_user', $id_user)->first())
            return ['status' => 'este usuario não possui produtos no carrinho'];

        return Cart::where('id_user', $id_user)->delete();
    }

    public function updateDebitBalanceClient($id_client, $total_sale, $discount = 0)
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
        if (!$request->id_sales) {
            return "Informe pelo menos uma venda";
        }

        $payClient = 0;
        $sales = 0;

        DB::beginTransaction();

        try {
            $sales = Sale::whereIn('id', $request->id_sales)
                ->where('id_client', $request->id_client)
                ->where('paied', 'no')
                ->lockForUpdate()
                ->update(['paied' => 'yes']);

            if ($sales) {
                $payClient = Sale::whereIn('id', $request->id_sales)
                    ->where('id_client', $request->id_client)
                    ->where('paied', 'yes')
                    ->sum(DB::raw('total_sale - discount'));

                $client = Client::where('id', $request->id_client)
                    ->lockForUpdate()
                    ->first();

                if ($client) {
                    $client->debit_balance -= $payClient;
                    $client->update();
                }
            }

            DB::commit();

            return "O pagamento de $sales vendas no total de R$ " . $payClient / 100 . " foi realizado com sucesso";
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
