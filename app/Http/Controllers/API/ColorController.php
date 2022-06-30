<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Models\Api\Color;
use App\Models\Util\ModuleQueryMethods\ModuleQueries;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get color records
        $colors = ModuleQueries::getAllModelRecords('color', 'API');
        if( !$colors->data ){
            return response()->json($colors->message, 404);
        }
        $colors = $colors->data;

        return $colors;
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
            'slug' => 'string|max:50',
        ]);

        // create record
        try {
            DB::beginTransaction();

            $color = new Color([
                'name'        => $request['name'],
                'slug'        => $request['slug'],
                'description' => $request['description'],
            ]);
            $color->save();

        } catch( QueryException $queryEx ) {
            DB::rollBack();

            $queryEx->errorInfo[1] == 1062 ? 
                $message = 'Color name or slug already existed, please try again!' : 
                $message = 'Problem occured while trying to save color record into database!' ;

            return response()->json($message, 404);
        }

        DB::commit();
        return $color;
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get color record
        $color = ModuleQueries::findModelRecordById('color', $id, 'API');
        if( !$color->data ){
            return response()->json($color->message, 404);
        }
        $color = $color->data;

        return $color;
    }

    /**
     * Dispaly the speciic resource based on given field and value.
     * @param string $field
     * @param string $value
     * @return \Illuminate\Http\Response
     */
    public function search( $field, $value )
    {
        // search color by given field and value
        $color = ModuleQueries::findModelRecordByScopeLike('color', $field, $value, 'API');
        if( !$color->data ){
            return response()->json($color->message, 404);
        }
        $color = $color->data;

        return $color;
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get color record
        $color = ModuleQueries::findModelRecordById('color', $id, 'API');
        if( !$color->data ){
            return response()->json($color->message, 404);
        }
        $color = $color->data;

        // validate request data
        $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string|max:50',
        ]);

        // update record
        try {
            DB::beginTransaction();

            $color->update( $request->all() );

        } catch( QueryException $queryEx ) {
            DB::rollBack();

            $queryEx->errorInfo[1] == 1062 ?
                $message = 'Color name or slug dupplicated or already existed, please try again!' : 
                $message = 'Problem occured while trying to update color record in database!' ;

            return response()->json($message, 404);
        }

        DB::commit();
        return $color;
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get color record
        $color = ModuleQueries::findModelRecordById('color', $id, 'API');
        if( !$color->data ){
            return response()->json($color->message, 404);
        }
        $color = $color->data;

        // delete color
        $color->delete();

        return $color;
    }
}
