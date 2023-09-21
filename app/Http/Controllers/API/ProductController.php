<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Api\Product;
use App\Models\Util\ModuleQueryMethods\ModuleQueries;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get records
        $products = ModuleQueries::getAllModelRecords('product', 'API');
        if( !$products->data ){
            return response()->json($products->message, 404);
        }
        $products = $products->data;

        return $products;
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate all mandatory request data
        $request->validate([
            'name'              => 'required|max:255',
            'country_of_origin' => 'required|max:50',
        ]);

        // get mandatory module records
        $mandatoryModules = Product::requestsValidation($request);
        if( !$mandatoryModules->data ){
            return response()->json($mandatoryModules->message, 404);
        }
        $brand           = $mandatoryModules->brand;
        $category        = $mandatoryModules->category;
        $name            = $mandatoryModules->name;
        $barcode         = $mandatoryModules->barcode;
        $countryOfOrigin = $mandatoryModules->countryOfOrigin;

        // create data
        try {
            DB::beginTransaction();

            $product = new Product([
                'name'              => $name,
                'barcode'           => $barcode,
                'cost'              => 0.00,
                'category_id'       => $category->id,
                'brand_id'          => $brand->id,
                'country_of_origin' => $countryOfOrigin,
            ]);
            $product->save();
        } catch ( QueryException $ex ) {
            DB::rollBack();

            $message = $ex->errorInfo[1] == 1062 ? 
                'Duplicated product name entry, please choose another name and try again!' : 
                'Problem occured while trying to create new product record and store into database!';

            $devMessage = $ex->getMessage();

            return response()->json([
                'message'    => $message,
                'devMessage' => $devMessage,
            ], 409);
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
        $product = ModuleQueries::findModelRecordById('product', $id, 'API');
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
        $product = ModuleQueries::findModelRecordByScopeLike('product', $field, $value, 'API');
        if( !$product->data ) {
            return response()->json($product->message, 404);
        }
        $product = $product->data;

        return $product; 
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get mandatory modules records
        $mandatoryModules = Product::validateExistingModulesOfCorrespondingProduct( $request, $id );
        if( !$mandatoryModules->data ){
            return response()->json( $mandatoryModules->message, 404 );
        }
        $product = $mandatoryModules->product;

        // update data
        try {
            DB::beginTransaction();

            $product->update( $request->all() );
        } catch( QueryException $ex ) {
            DB::rollBack();

            $message = $ex->errorInfo[1] == 1062 ? 
                'Duplicated product name entry, please choose another name and try again!' : 
                'Problem occured while trying to update product record into database';

            $devMessage = $ex->getMessage();

            return response()->json([
                'message'    => $message,
                'devMessage' => $devMessage,
            ], 409);
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
        // get record
        $product = ModuleQueries::findModelRecordById('product', $id, 'API');
        if( !$product->data ){
            return response()->json($product->message, 404);
        }
        $product = $product->data;

        // delete data
        try {
            DB::beginTransaction();

            $product->delete();
        } catch ( Exception $ex ) {
            DB::rollBack();

            return response()->json([
                'message'    => 'Problem occured while trying to delete product record from database!',
                'devMessage' => $ex->getMessage(),
            ], 404);
        }

        return $product;
    }
}
