<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Cart;
use App\Models\ItensOnSale;

use App\Http\Requests\SaleRequest;
use App\Models\Budget;
use App\Models\Client;
use App\Models\ItensOnBudget;
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

        return $query->with(['itens', 'client', 'user'])->orderBy('id', 'desc')->get();
    }

    // verifica se o request recebido do front esta atualizado com valor existente em banco
    public function checkIfSaleIsUpdatedWithCart($idUser, $total_sale, $total_itens)
    {
        $products = Cart::where('id_user', $idUser)->get();

        $total = $products->sum(function ($product) {
            return $product->item_value * $product->qtd;
        });

        return (count($products) == $total_itens) and $total_sale == $total || $total_sale == $total;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(SaleRequest $request)
    {

        /**
         *este metodo passou por uma refatoração, onde ele verifica se existe ou se recebe o id da pessoa que realizou a venda, id_seller,
         *se existir ele altera o valor de id user na venda para o id do vendedor, mas continua apagando os produtos no carrinho utilizando
         *o id de usuario obtido no request, id_user, que seria o equivalente ao usuario logado no sistema, para remover os produtos do carrinho
         */

        $form = $request->all();


        if (!$this->checkIfSaleIsUpdatedWithCart($request->id_user, $request->total_sale, $request->total_itens))
            throw new Exception('Seu carrinho está desatualizado, por favor feche a pagina, atualize a página (de um F5) e tente novamente!');

        if ($form['type_sale'] == "on_term")
            $form['paied'] = 'no';

        if ($form['type_sale'] == "on_term" && $form['paied'] !== "no")
            throw new Exception('Ocorreu um erro nesta transação, por favor verifique se a mesma foi concluída, se não tente novamente, ou fale com suporte.');

        $sale = null;

        $id_user = null;

        $request->id_seller && $request->id_seller != null ?  $id_user = $request->id_seller : $id_user = $request->id_user;



        // a variavel $sale abaixo é inserida dentro do metodo transaction com operador & para referenciar a variavel original e não criar uma copia dela, pois se criasse
        // uma copia quaisquer alterações feitas dentro da função não seriam refletidas fora dela.

        DB::transaction(function () use ($form, $request, $id_user, &$sale) {

            try {
                $form['id_user'] = $id_user;
                $sale = Sale::create($form);

                $products = Cart::where('id_user', $request->id_user)->get();

                if ($this->saveItensOnSale($products, $sale->id, $sale->id_user))
                    $this->dropProductsPerUser($request->id_user);
            } catch (Exception $err) {

                throw new Exception('Ocorreu um erro ' . $err);
            } finally {
                if ($sale->type_sale == "on_term" && $sale->paied == "no") {
                    $this->updateDebitBalanceClient($sale->id_client, $sale->total_sale, $sale->discount);
                }
            }
        }, 5);

        return [
            "sale" => Sale::with(['itens', 'client', 'user'])->orderBy('id', 'desc')->where('id', $sale->id)->get()
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

    public function dropProductsPerUserFromBudget($id_budget)
    {
        if (!ItensOnBudget::where('id_sale', $id_budget)->first())
            return ['status' => 'este usuario não possui produtos no carrinho'];

        return ItensOnBudget::where('id_sale', $id_budget)->delete();
    }

    public function dropBudget($id_budget)
    {
        if (!Budget::where('id', $id_budget)->first())
            return ['status' => 'este orçamento não existe!'];

        return Budget::where('id', $id_budget)->delete();
    }

    public function saveItensOnSale($products, $saleId, $userId)
    {
        foreach ($products as $product) {
            $item = new ItensOnSale();
            $item->id_sale = $saleId;
            $item->id_user = $userId;
            $item->id_product = $product->id_product;
            $item->qtd = $product->qtd;
            $item->obs = $product->obs;
            $item->item_value = $product->item_value;
            $item->save();
        }
        return true;
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
                ->where('type_sale', 'on_term')
                ->where('paied', 'no')
                ->lockForUpdate()
                ->update(['paied' => 'yes']);

            if ($sales <= 0) {
                throw new Exception("Erro ao processar o pagamento ");
            };

            if ($sales > 0) {
                $payClient = Sale::whereIn('id', $request->id_sales)
                    ->where('id_client', $request->id_client)
                    ->where('paied', 'yes')
                    ->sum(DB::raw('total_sale - discount'));

                $client = Client::where('id', $request->id_client)
                    ->lockForUpdate()
                    ->first();

                if ($client) {
                    $client->debit_balance -= $payClient;
                    $client->marked = 0;
                    $client->update();
                }
            }
            DB::commit();
            return "O pagamento de $sales vendas no total de R$ " . $payClient . " foi realizado com sucesso";

        } catch (Exception $e) {
            DB::rollback();
            return "Erro ao processar o pagamento: " . $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function changeBudgetToSale(SaleRequest $request)
    {
        $form = $request->all();

        if ($form['type_sale'] == "on_term")
            $form['paied'] = 'no';

        if ($form['type_sale'] == "on_term" && $form['paied'] !== "no")
            throw new Exception('Ocorreu um erro nesta transação, por favor verifique se a mesma foi concluída, se não tente novamente, ou fale com suporte.');

        $sale = null;

        $id_user = null;

        $request->id_seller && $request->id_seller != null ?  $id_user = $request->id_seller : $id_user = $request->id_user;

        // a variavel $sale abaixo é inserida dentro do metodo transaction com operador & para referenciar a variavel original e não criar uma copia dela, pois se criasse
        // uma copia quaisquer alterações feitas dentro da função não seriam refletidas fora dela.

        DB::transaction(function () use ($form, $request, $id_user, &$sale) {

            try {
                $form['id_user'] = $id_user;
                $sale = Sale::create($form);

                // $products = ItensOnBudget::where('id_user', $request->id_user)->get();
                $products = ItensOnBudget::where('id_sale', $request->id_budget)->get();

                if ($this->saveItensOnSale($products, $sale->id, $sale->id_user)) {
                    $this->dropProductsPerUserFromBudget($request->id_budget);
                    $this->dropBudget($request->id_budget);
                }
            } catch (Exception $err) {

                throw new Exception('Ocorreu um erro ' . $err);
            } finally {
                if ($sale->type_sale == "on_term" && $sale->paied == "no") {
                    $this->updateDebitBalanceClient($sale->id_client, $sale->total_sale, $sale->discount);
                }
            }
        }, 5);

        return [
            "sale" => Sale::with(['itens', 'client', 'user'])->orderBy('id', 'desc')->where('id', $sale->id)->get()
        ];
    }


    public function blockCustomersWithOverdueSales()
    {
        $daysAgo = now()->subDays(45);

        $sales = Sale::where('created_at', '<', $daysAgo)
            ->where('type_sale', 'on_term')
            ->where('paied', 'no')
            ->get();

        $clientIds = $sales->pluck('id_client')->unique();


        $blockedClients = Client::whereIn('id', $clientIds)->where('marked', 0)->get();

        // Você também pode optar por executar as atualizações em lotes para melhor desempenho
        Client::whereIn('id', $clientIds)->where('marked', 0)->chunk(200, function ($clients) {
            foreach ($clients as $client) {
                $client->marked = 1;
                $client->save();
            }
        });

        return $blockedClients;
    }
}
