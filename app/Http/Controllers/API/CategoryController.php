<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Exception;
use App\Models\Api\Category;
use App\Models\Util\ModuleQueryMethods\ModuleQueries;

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
        // get all category records
        $categories = ModuleQueries::getAllModelRecords('category', 'API');
        if( !$categories->data ){
            return response()->json($categories->message , 404);
        }
        $categories = $categories->data;

        return $categories;
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
        ]);

        // create record
        try {
            DB::beginTransaction();

            $category = new Category([
                'name'        => $request['name'],
                'description' => $request['description'],
            ]);
            $category->save();

        } catch(QueryException $queryEx){
            DB::rollBack();
            $queryEx->errorInfo[1] == 1062 ?
                $message = 'Category name already exist, please choose another name and try again!' :
                $message = 'Problem occured while trying to save category record into database!';

            return response()->json($message, 404);
        }

        DB::commit();
        return $category;
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get category record
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get category record
        $category = ModuleQueries::findModelRecordById('category', $id, 'API');
        if( !$category->data ){
            return response()->json($category->message, 404);
        }
        $category = $category->data;

        // validate requests
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // update record
        try {
            DB::beginTransaction();
            $category->update( $request->all() );
            
        } catch(QueryException $queryEx) {
            DB::rollBack();
            $queryEx->errorInfo[1] == 1062 ?
                $message = 'Category name already exist, please choose another name and try again!' :
                $message = 'Problem occured while trying to update category record!' ;

            return response()->json($message, 404);
        }

        DB::commit();
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get category record
        $category = ModuleQueries::findModelRecordById('category', $id, 'API');
        if( !$category->data ){
            return response()->json($category->message, 404);
        }
        $category = $category->data;

        // delete record
        try {
            DB::beginTransaction();
            $category->delete();
            
        } catch(Exception $ex) {
            DB::rollBack();
            return response()->json('Problem occured while trying to delete category record from database!', 404);
        }

        DB::commit();
        return $category;
    }
}
