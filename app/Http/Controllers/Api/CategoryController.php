<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\Category as CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json(['Exibição de categorias.', CategoryResource::collection($categories)]);
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
            'nome'      => 'required|unique:categories|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $category = Category::create($input);
        
        return response()->json(['categoria criada com sucesso.', new CategoryResource($category)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json('Nenhuma categoria encontrada', 404); 
        }
        return response()->json([new CategoryResource($category)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
       
        $validator = Validator::make($input,[
            'nome'      => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $category->nome = $request->nome;
        $category->descricao = $request->descricao;
        $category->save();
        
        return response()->json(['Categoria Atualizada com Sucesso.', new CategoryResource($category)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
   
        return response()->json('Categoria deletada com Sucesso !!');
    }
}
