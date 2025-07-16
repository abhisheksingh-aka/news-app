<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\News;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    public function index(Request $request)
    {
        try {
        $requestArr = $request->all();
        if(isset($requestArr['published_at'])) {
            $var[] = ['published_at',$requestArr['published_at']];
        }
        if(isset($requestArr['source_name'])) {
            $var[] = ['source_name',$requestArr['source_name']];
        }
        if(isset($requestArr['author'])) {
            $var[] = ['author',$requestArr['author']];
        }

        $condition = $var;
        $result = News::listNews($condition, \Config::get('constants.admin_pagination'));

        return response()->json($result);
        } catch (\Exception $e) {
            echo "something wrong   =>" . $e->getMessage() . "and get line is " . $e->getLine();
            die;
        }
    }
}
