<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBudgetRequest;
use App\Models\Budget;
use App\Models\Cart;
use App\Models\ItensOnBudget;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Sale::with(['itens', 'client'])->orderBy('id', 'desc')->get();
        $query =  Budget::query();

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
    public function store(StoreBudgetRequest $request)
    {
        $form = $request->all();


        $budget = null;


        // a variavel $budget abaixo é inserida dentro do metodo transaction com operador & para referenciar a variavel original e não criar uma copia dela, pois se criasse
        // uma copia quaisquer alterações feitas dentro da função não seriam refletidas fora dela.

        DB::transaction(function () use ($form, $request, &$budget) {

            try {
                $budget = Budget::create($form);

                $products = Cart::where('id_user', $request->id_user)->get();

                if ($this->saveItensOnBudget($products, $budget->id, $budget->id_user))
                    $this->dropProductsPerUser($budget->id_user);
            } catch (Exception $err) {

                throw new Exception('Ocorreu um erro ' . $err);
            }
        }, 5);

        return [
            "budget" => Budget::with(['itens', 'client'])->orderBy('id', 'desc')->where('id', $budget->id)->get()
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
        return Budget::find($id) ? Budget::find($id) : ['error' => '404'];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return ['error' => 'The sale don´t can updated'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return ['error' => 'The sale don´t can updated'];
    }

    public function dropProductsPerUser($id_user)
    {
        if (!Cart::where('id_user', $id_user)->first())
            return ['status' => 'este usuario não possui produtos no carrinho'];

        return Cart::where('id_user', $id_user)->delete();
    }

    public function saveItensOnBudget($products, $saleId, $userId)
    {
        foreach ($products as $product) {
            $item = new ItensOnBudget();
            $item->id_sale = $saleId;
            $item->id_user = $userId;
            $item->id_product = $product->id_product;
            $item->qtd = $product->qtd;
            $item->obs = $product->obs;
            $item->item_value = $product->sale_value;
            $item->save();
        }
        return true;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
