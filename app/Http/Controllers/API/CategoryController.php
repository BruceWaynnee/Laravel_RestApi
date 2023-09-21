<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Api\Category;
use App\Models\Util\ModuleQueryMethods\ModuleQueries;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get records
        $categories = ModuleQueries::getAllModelRecords('category', 'API');
        if( !$categories->data ){
            return response()->json($categories->message , 404);
        }
        $categories = $categories->data;

        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate all mandatory requests data
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // create data
        try {
            DB::beginTransaction();

            $category = new Category([
                'name'        => $request['name'],
                'description' => $request['description'],
            ]);
            $category->save();
        } catch ( QueryException $queryEx ) {
            DB::rollBack();

            $message = $queryEx->errorInfo[1] == 1062 ?
                        'Category name already exist, please choose another name and try again!' : 
                        'Problem occured while trying to save category record into database!';

            $devMessage = $queryEx->getMessage();

            return response()->json([
                'message'    => $message,
                'devMessage' => $devMessage,
            ], 404);
        }
        DB::commit();

        return $category;
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get record
        $category = ModuleQueries::findModelRecordById('category', $id, 'API');
        if( !$category->data ){
            return response()->json($category->message, 404);
        }
        $category = $category->data;

        return $category;
    }

    /**
     * Display the specified resource based on given field and value.
     * @param string $field
     * @param string $value
     * @return \Illuminate\Http\Response
     */
    public function search($field, $value){
        // search category by given field and value
        $category = ModuleQueries::findModelRecordByScopeLike('category', $field, $value, 'API');
        if( !$category->data ){
            return response()->json($category->message, 404);
        }
        $category = $category->data;

        return $category;
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate requests
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // get record
        $category = ModuleQueries::findModelRecordById('category', $id, 'API');
        if( !$category->data ){
            return response()->json($category->message, 404);
        }
        $category = $category->data;

        // update data
        try {
            DB::beginTransaction();

            $category->update( $request->all() );            
        } catch ( QueryException $queryEx ) {
            DB::rollBack();

            $message = $queryEx->errorInfo[1] == 1062 ?
                        'Category name already exist, please choose another name and try again!' : 
                        'Problem occured while trying to update category record!' ;

            $devMessage = $queryEx->getMessage();

            return response()->json([
                'message'    => $message,
                'devMessage' => $devMessage,
            ], 404);
        }
        DB::commit();

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get record
        $category = ModuleQueries::findModelRecordById('category', $id, 'API');
        if( !$category->data ){
            return response()->json($category->message, 404);
        }
        $category = $category->data;

        // delete record
        try {
            DB::beginTransaction();

            $category->delete();            
        } catch ( Exception $ex ) {
            DB::rollBack();

            return response()->json([
                'message'    => 'Problem occured while trying to delete category record from database!',
                'devMessage' => $ex->getMessage(),
            ], 404);
        }
        DB::commit();

        return $category;
    }
}
