<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Api\Size;
use App\Models\Util\ModuleQueryMethods\ModuleQueries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get size records
        $sizes = ModuleQueries::getAllModelRecords('size', 'API');
        if( !$sizes->data ){
            return response()->json($sizes->message, 404);
        }
        $sizes = $sizes->data;

        return $sizes;
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request value
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'string|max:50',
        ]);

        // create record
        try {
            DB::beginTransaction();
            
            $size = new Size([
                'name'        => $request['name'],
                'slug'        => $request['slug'],
                'description' => $request['description'],
            ]);
            $size->save();

        } catch( QueryException $queryEx ) {
            DB::rollBack();
            $queryEx->errorInfo[1] == 1062 ?
                $message = 'Size name or slug is already existed, please try again!' :
                $message = 'Problem occured while trying to save size record into database!' ;

            return response()->json($message, 404);
        }

        DB::commit();
        return $size;
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get size record
        $size = ModuleQueries::findModelRecordById('size', $id, 'API');
        if( !$size->data ){
            return response()->json($size->message, 404);
        }
        $size = $size->data;

        return $size;
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
        $size = ModuleQueries::findModelRecordByScopeLike('size', $field, $value, 'API');
        if( !$size->data ) {
            return response()->json($size->message, 404);
        }
        $size = $size->data;

        return $size; 
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get size record
        $size = ModuleQueries::findModelRecordById('size', $id, 'API');
        if( !$size->data ){
            return response()->json($size->message, 404);
        }
        $size = $size->data;

        // validate request
        $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string|max:50',
        ]);

        // update record
        try {
            DB::beginTransaction();
            $size->update( $request->all() );

        } catch(QueryException $ex) {
            DB::rollBack();
            $ex->errorInfo[1] == 1062 ?
                $message = 'Size name or slug already exist, please choose another name and try again!' :
                $message = 'Problem occured while trying to update size record!' ;

            return response()->json($message, 404);
        }

        DB::commit();
        return $size;
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get size record
        $size = ModuleQueries::findModelRecordById('size', $id, 'API');
        if( !$size->data ){
            return response()->json($size->message, 404);
        }
        $size = $size->data;

        // delete size record
        $size->delete();

        return $size;
    }
}
