<?php


namespace App\Infrastructure\Orm;



class Query
{
    public function toArray(){
        $res = [];

        foreach (get_object_vars($this) as $key => $values){
            if( !is_null($values) ){
                $res[$key] = $values;
            }
        }

        return $res;
    }
}