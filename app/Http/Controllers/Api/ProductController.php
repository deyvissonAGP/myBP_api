<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Validator as IlluminateValidationValidator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json(['Exibição de Produtos', ProductResource::collection($products)]);
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
            'preco'     => 'required',
            'categoria_id' => 'required',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $product = Product::create($input);
        
        return response()->json(['Produto criado com sucesso.', new ProductResource($product)]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json('Nenhum produto encontrado', 404); 
        }
        return response()->json([new ProductResource($product)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Product $product)
    {
        $input = $request->all();
       
        $validator = Validator::make($input,[
            'nome'      => 'required|string|max:255',
            'categoria_id' => 'required',
            // 'preco'     => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $product->nome = $request->nome;
        $product->categoria_id = $request->categoria_id;
        // $product->preco = $request->preco;
        $product->save();
        
        return response()->json(['Produto Atualizado com Sucesso.', new ProductResource($product)]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
   
        return response()->json('Produto deletado com Sucesso !!');
    }
}
