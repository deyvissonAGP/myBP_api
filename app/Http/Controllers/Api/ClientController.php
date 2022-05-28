<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client as ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        return response()->json(['Exibição de Clientes', ClientResource::collection($clients)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input,[
            'nome'      => 'required|string|max:255',
            'email'     => 'required|email',
            'telefone'  => 'required|max:17', 

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $client = Client::create($input);
        
        return response()->json(['Cliente cadastrado com sucesso.', new ClientResource($client)]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $client = Client::find($id);
        if (is_null($client)) {
            return response()->json('Nenhum cliente encontrado', 404); 
        }
        return response()->json([new ClientResource($client)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Client $client)
    {
        $input = $request->all();
       
        $validator = Validator::make($input,[
            'nome'      => 'required|string|max:255',
            'email'     => 'required|email',
            'telefone'  => 'required|max:17', 
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $client->nome = $request->nome;
        $client->email = $request->email;
        $client->telefone = $request->telefone;
        $client->save();
        
        return response()->json(['Cliente Atualizado com Sucesso.', new ClientResource($client)]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
   
        return response()->json('Cliente deletado com Sucesso !!');
    }
}
