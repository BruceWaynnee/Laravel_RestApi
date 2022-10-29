<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Api\Brand;
use App\Models\Util\ModuleQueryMethods\ModuleQueries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all brand records
        $brands = ModuleQueries::getAllModelRecords('brand', 'API');
        if( !$brands->data ){
            return response()->json($brands->message, 404);
        }
        $brands = $brands->data;

        return $brands;
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
            'name' => 'required|max:255',
            'slug' => 'string:max:50',
        ]);

        // create record
        try {
            DB::beginTransaction();

            $brands = new Brand([
                'name'        => $request['name'],
                'slug'        => $request['slug'],
                'description' => $request['description'],
            ]);
            $brands->save();

        } catch ( QueryException $queryEx ) {
            DB::rollBack();

            $queryEx->errorInfo[1] == 1062 ? 
                $message = 'Brand name or slug already existed, please try again!' :
                $message = 'Problem occured while trying to save brand record into database!';

            return response()->json($message, 404);
        }

        DB::commit();
        return $brands;
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get brand record
        $brand = ModuleQueries::findModelRecordById('brand', $id, 'API');
        if( !$brand->data ){
            return response()->json($brand->message, 404);
        }
        $brand = $brand->data;

        return $brand;
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get brand record
        $brand = ModuleQueries::findModelRecordById('brand', $id, 'API');
        if( !$brand->data ){
            return response()->json($brand->message, 404);
        }
        $brand = $brand->data;

        // validate all mandatory request data
        $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string:max:50',
        ]);

        // update record
        try {
            DB::beginTransaction();

            $brand->update( $request->all() );

        } catch ( QueryException $queryEx ) {
            DB::rollBack();

            $queryEx->errorInfo[1] == 1062 ? 
                $message = 'Brand name or slug already existed, please try again!' :
                $message = 'Problem occured while trying to update brand record into database!';
            
            return response()->json($message, 404);
        }

        DB::commit();
        return $brand;
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get brand record
        $brand = ModuleQueries::findModelRecordById('brand', $id, 'API');
        if( !$brand->data ){
            return response()->json($brand->message, 404);
        }
        $brand = $brand->data;

        // delete brand
        $brand->delete();

        return $brand;
    }
}
