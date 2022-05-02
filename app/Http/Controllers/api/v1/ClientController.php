<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use DateTime;
use ErrorException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        return Client::where('active', true)->orderBy('full_name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $array = ['status' => 'created'];
        $array['client'] = Client::create($request->all());
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
        // return Client::update($request->all());

        $array = ['status' => 'updated'];
        $client->update($request->all());
        $array['client'] = $client;
        return $array;
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

        if($client->debit_balance != 0){
           throw new HttpException(304);

        }

        Client::where('id', $client->id)->update(['active' => 0, 'inactive_date' => new DateTime()]);
        return $array;
    }
}
