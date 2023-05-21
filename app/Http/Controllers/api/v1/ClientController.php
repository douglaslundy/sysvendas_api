<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Models\Addresses;
use App\Models\Client;
use DateTime;
use ErrorException;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Client::where('active', true)->get();
        return Client::with(['addresses'])->where('active', true)->orderBy('full_name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        DB::beginTransaction();
        try {
            $array = ['status' => 'created'];

            $client = Client::create($request->all());

            $address = new Addresses();
            $address->id_client = $client->id;
            $address->zip_code = $request->input('addresses.zip_code');
            $address->city = $request->input('addresses.city');
            $address->street = $request->input('addresses.street');
            $address->number = $request->input('addresses.number');
            $address->district = $request->input('addresses.district');
            $address->complement = $request->input('addresses.complement');

            $address->save();
            $array['client'] = $client;

            DB::commit();

            return $array;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Client::where('active', true)->find($id) ? Client::find($id) : ['error' => '404'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {

        DB::beginTransaction();
        try {
            $array = ['status' => 'updated'];
            $client->update($request->all());
            $array['client'] = $client;

            $address = Addresses::where('id_client', $client->id)->first();

            if (!$address)
                $address = new Addresses();

            $address->id_client = $client->id;
            $address->zip_code = $request->input('addresses.zip_code');
            $address->city = $request->input('addresses.city');
            $address->street = $request->input('addresses.street');
            $address->number = $request->input('addresses.number');
            $address->district = $request->input('addresses.district');
            $address->complement = $request->input('addresses.complement');

            $address->save();
            $array['client'] = $client;

            DB::commit();

            return $array;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $array = ['status' => 'inactivated'];
        // $client->delete($client);

        if ($client->debit_balance != 0) {
            throw new Exception("Este cliente possui débitos em aberto e não pode ser excluido", 304);
        }

        Client::where('id', $client->id)->update(['active' => 0, 'inactive_date' => new DateTime()]);
        return $array;
    }
}
