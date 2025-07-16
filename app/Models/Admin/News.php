<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';

    public static function listNews($condition = [], $pagination)
    {
        $result = isset($condition)? self::where($condition)->paginate($pagination) : self::paginate($pagination);
        return $result;
    }

    public static function getNews($condition = [])
    {
        $result = self::where($condition)->get()->first();
        return $result;
    }


    public static function storeNews($request)
    {
        $setArr = [];

        if(isset($request['title']) && $request['title'] != '') {
            $setArr["source_id"] = isset($request['source_id']) ? $request['source_id'] : null;
            $setArr["source_name"] = isset($request['source_name']) ? $request['source_name'] : null;
            $setArr["author"] = isset($request['author']) ? $request['author'] : null;
            $setArr["title"] = isset($request['title']) ? $request['title'] : null;
            $setArr["description"] = isset($request['description']) ? $request['description'] : null;
            $setArr["content"] = isset($request['content']) ? $request['content'] : null;
            $setArr["url"] = isset($request['url']) ? $request['url'] : null;
            $setArr["url_image"] = isset($request['url_image']) ? $request['url_image'] : null;
            $setArr["published_at"] = isset($request['published_at']) ? $request['published_at'] . " 00:00:00" : null;
            $setArr["status"] = isset($request['status']) ? $request['status'] : 'Disabled';
            $setArr["client_user_id"] = isset($request['client_user_id']) ? $request['client_user_id'] : null;
            if( !is_array($setArr) || empty($setArr)){
                return false;
            }

            \DB::beginTransaction();
            $insertId = self::insertGetId($setArr); // Eloquent approach
            \DB::commit();
            return $insertId;
        }
    }

    public static function updateNews($request)
    {
        $setArr = [];

        if(isset($request['id']) && $request['id'] != '') {
            $setArr["source_id"] = isset($request['source_id']) ? $request['source_id'] : null;
            $setArr["source_name"] = isset($request['source_name']) ? $request['source_name'] : null;
            $setArr["author"] = isset($request['author']) ? $request['author'] : null;
            $setArr["title"] = isset($request['title']) ? $request['title'] : null;
            $setArr["description"] = isset($request['description']) ? $request['description'] : null;
            $setArr["content"] = isset($request['content']) ? $request['content'] : null;
            $setArr["url"] = isset($request['url']) ? $request['url'] : null;
            $setArr["url_image"] = isset($request['url_image']) ? $request['url_image'] : null;
            $setArr["published_at"] = isset($request['published_at']) ? $request['published_at'] . " 00:00:00" : null;
            $setArr["status"] = isset($request['status']) ? $request['status'] : 'Disabled';
            $setArr["client_user_id"] = isset($request['client_user_id']) ? $request['client_user_id'] : null;
            if( !is_array($setArr) || empty($setArr)){
                return false;
            }
            $condition = [['id',$request["id"]]];

            \DB::beginTransaction();
            self::where($condition)->update($setArr);
            \DB::commit();
            return true;
        }
    }

    public static function deleteNews($id)
    {
        $setArr = [];
        if (isset($id) && $id != '') {
            $condition = [['id', $id]];
            $dataObj = self::where($condition)->get()->first();
            if($dataObj->status == 'Disabled') {
                $setArr["status"] = 'Enabled';
            } else {
                $setArr["status"] = 'Disabled';
            }
            if (!is_array($setArr) || empty($setArr)) {
                return false;
            }
            \DB::beginTransaction();
            self::where($condition)->update($setArr);
            \DB::commit();
            return true;
        }
    }
}
