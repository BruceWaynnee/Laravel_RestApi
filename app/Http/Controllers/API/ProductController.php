<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Api\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get product records from database.
        $products = Product::getProducts();
        if( !$products->data ){
            return response()->json($products->message, 404);
        }
        $products = $products->data;

        return $products;
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate all mandatory request data
        $request->validate([
            'name'              => 'required|max:255',
            'cost'              => 'required|numeric',
            'country_of_origin' => 'required|max:50',
        ]);

        // get category record
        $category = Product::getCategory($request['category_id']);
        if( !$category->data ){
            return response()->json($category->message, 404);
        }
        $category = $category->data;

        // create product record
        try {
            DB::beginTransaction();
            
            $product = new Product([
                'name'              => $request['name'],
                'barcode'           => $request['barcode'],
                'cost'              => $request['cost'],
                'category_id'       => $category->id,
                'country_of_origin' => $request['country_of_origin'],
            ]);
            $product->save();

        } catch( QueryException $ex ) {
            DB::rollBack();
            $errorCode = $ex->errorInfo[1];
            if( $errorCode == '1062' ) {
                $message = 'Duplicated product name entry, please choose another name and try again!';
            } else {
                $message = 'Duplicated product barcode entry, please choose another code and try again!';
            }
            return response()->json($message, 409);
        }
        
        DB::commit();
        return $product;
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get product record
        $product = Product::getProduct($id);
        if( !$product->data ){
            return response()->json($product->message, 404);
        }
        $product = $product->data;

        return $product; 
    }

    /**
     * Display the specified resource based on given field and value.
     * @param  string $field
     * @param  string $value
     * @return \Illuminate\Http\Response
     */
    public function search($field, $value)
    {
        // search product by given field and value
        $product = Product::scopeLike($field, $value);
        if( !$product->data ) {
            return response()->json($product->message, 404);
        }
        $product = $product->data;

        return $product; 
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get product record
        $product = Product::getProduct($id);
        if( !$product->data ){
            return response()->json($product->message, 404);
        }
        $product = $product->data;

        // get category id
        $category = Product::getCategory($request['category_id']);
        if( !$category->data ){
            return response()->json($category->message, 404);
        }
        $category = $category->id;
        
        // update product record
        try {
            DB::beginTransaction();
            
            // update category id
            $product->category_id = $category->id;
            // update product record
            $product->update( $request->all() );

        } catch( QueryException $ex ) {
            DB::rollBack();
            return $ex->getMessage();
            $errorCode = $ex->errorInfo[1];
            if( $errorCode == '1062' ) {
                $message = 'Duplicated product name entry, please choose another name and try again!';
            } else {
                $message = 'Duplicated product barcode entry, please choose another code and try again!';
            }
            return response()->json($message, 409);
        }
        
        DB::commit();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get product record
        $product = Product::getProduct($id);
        if( !$product->data ){
            return response()->json($product->message, 404);
        }
        $product = $product->data;

        // delete product record
        $product->delete();

        return $product; 
    }
}
