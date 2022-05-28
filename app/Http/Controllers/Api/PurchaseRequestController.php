<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseRequest as PurchaseRequestResource;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase = PurchaseRequest::all();

        return response()->json(['Exibição de Pedidos de compra', PurchaseRequestResource::collection($purchase)]);
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
            'status'      => 'required|string|max:10',
            'cliente_id'     => 'required',
            'produto_id' => 'required',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $purchase = PurchaseRequest::create($input);
        
        return response()->json(['Pedido de compra solicitado com sucesso.', new PurchaseRequestResource($purchase)]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $purchase = PurchaseRequest::find($id);
        if (is_null($purchase)) {
            return response()->json('Nenhum pedido de compra encontrado', 404); 
        }
        return response()->json([new PurchaseRequestResource($purchase)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  PurchaseRequest $purchase)
    {
        $input = $request->all();
       
        $validator = Validator::make($input,[
            'status'      => 'required|string|max:10',
            'cliente_id'     => 'required',
            'produto_id' => 'required',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $purchase->status = $request->status;
        $purchase->cliente_id = $request->cliente_id;
        $purchase->produto_id = $request->produto_id;
        $purchase->save();
        
        return response()->json(['Produto Atualizado com Sucesso.', new PurchaseRequestResource($purchase)]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseRequest $purchase)
    {
        $purchase->delete();
   
        return response()->json('Pedido de compra deletado com Sucesso !!');
    }
}
