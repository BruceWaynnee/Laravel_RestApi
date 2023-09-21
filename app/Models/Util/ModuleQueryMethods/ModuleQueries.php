<?php

namespace App\Models\Util\ModuleQueryMethods;
use Illuminate\Database\Eloquent\Model;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModuleQueries extends Model
{
    use HasFactory;

    protected static $namespace = '\\App\\Models\\';

    /**
     * Set respond object data and associative message array by
     * given data and given key value array of message;
     * @param String $data
     * @param KeyValueArray $messageArr
     * @return CustomObjectRespond $respond
     */
    public static function customObjectRespond($data, $messageArr){
        $respond = (object)[
            'data' => $data,
        ];

        foreach( $messageArr as $key => $message){
            $respond->$key = $message;
        }

        return $respond;
    }

    /**
     * Bind dynamic model path based on given
     * model entity name and entity extra patch namespace,
     * 
     * @param String $entity
     * @param String $entityNamespace
     * 
     * @return String $model
     * 
     * Ex: ```getAllModelRecords('Product', 'Api');```
     */
    public static function setModelName( $entity, $entityNamespace ){
        $model = self::$namespace;

        // namespace binding
        if( strlen($entityNamespace) > 0 ){
            $model .= ($entityNamespace . '\\');
        }

        $model .= ucwords($entity);
        
        return $model;
    }

    /**
     * Dynamic query all records based on given entity from database.
     * By default the model namespace located in App\Models,
     * provide $entityNamespace for additional sub model namespace.
     * 
     * Ex: ```getAllModelRecords('Product', 'Api');```
     * 
     * @param String $entity
     * @param String[Optional] $entityNamespace
     * 
     * @return ObjectRespond [data: data_result, message & detailMessage: result_message] 
     */
    public static function getAllModelRecords( $entity, $entityNamespace = '' ){
        $model = self::setModelName($entity, $entityNamespace);

        try {
            $modelRecord = $model::all();
            
            $respond = self::customObjectRespond($modelRecord,
                array('message' => 'Successful getting all '.$entity.' records from database')
            );

        } catch(ModelNotFoundException | Exception $ex) {
            $entity = strtolower($entity);

            return self::customObjectRespond(false,
                array(
                        'message'       => 'Problem occured while trying to get '.$entity.' record from database!',
                        'detailMessage' => $ex->getMessage(),
                    )
            );
        }

        return $respond;
    }

    /**
     * Dynamic query/find specific record based on given entity, and id from database.
     * By default the model namespace located in App\Models,
     * provide $entityNamespace for additional sub model namespace.
     * 
     * Ex: ```findModelRecordById('Product', 1, 'Api');```
     * 
     * @param String $entity
     * @param Integer $id
     * @param String[Optional] $entityNamespace
     * 
     * @return ObjectRespond [data: data_result, message & detailMessage: result_message] 
     */
    public static function findModelRecordById( $entity, $id, $entityNamespace = '' ){
        $model = self::setModelName($entity, $entityNamespace);

        try {
            $modelRecord = $model::findOrFail($id);
            
            $respond = self::customObjectRespond($modelRecord,
                array('message' => ucwords($entity).' record found')
            );

        } catch(ModelNotFoundException $ex) {
            return self::customObjectRespond(false,
                array(
                        'message'       => ucwords($entity).' record not found!',
                        'detailMessage' => $ex->getMessage(),
                    )
            );
        }

        return $respond;
    }

    /**
     * Dynamic query/find specific record based on given entity, 
     * field name and field value from database.
     * By default the model namespace located in App\Models,
     * provide $entityNamespace for additional sub model namespace.
     * 
     * Ex: ```findModelRecordByScopeLike('Product', 'name', 'iphone' ,'Api');```
     * 
     * @param String $entity
     * @param Integer $id
     * @param String[Optional] $entityNamespace
     * 
     * @return ObjectRespond [data: data_result, message & detailMessage: result_message] 
     */
    public static function findModelRecordByScopeLike( $entity, $field, $value, $entityNamespace = '' ){
        $model = self::setModelName($entity, $entityNamespace);
        $field = strtolower($field);

        try {
            $modelRecord = $model::where($field, 'LIKE', '%'.$value.'%')->get();
            
            $respond = self::customObjectRespond($modelRecord,
                array('message' => 'Successful getting '.$entity.' record by '.$field)
            );

        } catch(ModelNotFoundException $ex) {
            return self::customObjectRespond(false,
                array(
                        'message'       => 'Problem occured while trying to search '.$entity.' record by '.$field,
                        'detailMessage' => $ex->getMessage(),
                    )
            );
        }

        return $respond;
    }
}
