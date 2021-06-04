<?php

namespace ActiveLogic\ComplexQuery;

use Illuminate\Support\Facades\DB;

trait HasComplexQueries
{
    /**
     * queryWithPath
     */
    public static function queryWithPath(string $path, array $params = [])
    {
        $full_query_path = database_path('queries/' . $path . '.sql');

        if(!file_exists($full_query_path)){
            throw new \Exception("Missing query resource file located at '{$full_query_path}'");
        }

        $query = ( new self() )->fullQuery($full_query_path, $params);
        $array = [];

        foreach(DB::select( DB::raw($query) ) as $data){
            $object = new self();

            foreach(array_keys((array)$data) as $key){
                $object->$key = $data->$key;
            }

            $array[] = $object;
        }

        return collect($array);
    }

    /**
     * Query
     */
    private function fullQuery(string $path = null, array $params = [])
    {
        $data = file_get_contents($path);

        foreach($params as $param => $value){
            $key = '$' . $param;

            if(strpos($data, $key) === false){
                throw new \Exception("Missing {$key} in query resource file");
            }

            $data = str_replace($key, $value, $data);
        }

        return $data;
    }
}
