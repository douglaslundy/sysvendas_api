<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use DateTime;
use Symfony\Component\HttpKernel\Exception\HttpException;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return User::where('active', true)->orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $array = ['status' => 'created'];
        $array['user'] = User::create($request->all());
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
        return User::where('active', true)->find($id) ? User::find($id) : ['error' => '404'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $array = ['status' => 'updated'];
        $user->update($request->all());
        $array['user'] = $user;
        return $array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $array = ['status' => 'inactivated'];
        // $client->delete($client);

        // if($user->debit_balance != 0){
        //    throw new HttpException(304);

        // }

        User::where('id', $user->id)->update(['active' => 0, 'inactive_date' => new DateTime()]);
        return $array;
    }
}
