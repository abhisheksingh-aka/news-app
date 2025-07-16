<?php

namespace App\library;
use \Illuminate\Http\Response;
class ApiResponse {        

    public static function error($message, $detail, $code, $success =''){
        if(empty($success)){
            return response()->json( ['error' =>   $message, 'data' =>$detail ,'status_code' => $code]);    
        }
        return response()->json( ['error' =>   $message, 'data' =>$detail ,'status_code' => $code,'success'=>$success]);
    }
    public static function success($message, $data, $code){        
        return response()->json( ['success' =>   $message,"data"=> $data, 'status_code' => $code]);        
    }    
}