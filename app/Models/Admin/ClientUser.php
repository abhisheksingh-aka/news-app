<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientUser extends Model
{
    use HasFactory;

//    protected $table = 'client_users';

    public function Role() {
        return $this->hasOne('App\Models\Admin\Role', 'id', 'role_id');
    }

    public function User() {
        return $this->hasOne('App\Models\Admin\ClientUser', 'id', 'client_user_id');
    }

    public static function ValidateUser($requestArr = [])
    {
        if(is_array($requestArr) && !empty($requestArr)) {

            $clientUserExists = Self::where([['email',$requestArr["email"]],['password',md5($requestArr["password"])],['status', 'Active']])->exists();
            if($clientUserExists) {
                $clientUserObject = self::where([['email',$requestArr["email"]],['password',md5($requestArr["password"])]])->first();
                return $clientUserObject;
            }
        }
    }

    public static function listUser($condition = [], $pagination)
    {
        $result = isset($condition)? self::where($condition)->paginate($pagination) : [];
        return $result;
    }

    public static function userArr($condition = [])
    {
        $result = isset($condition)? self::where($condition)->get() : [];
        return $result;
    }

    public static function getUser($condition = [])
    {
        $result = self::where($condition)->with('User')->get()->first();
        return $result;
    }

    public static function storeUser($request)
    {
        $setArr = [];

        if(isset($request['email']) && $request['email'] != '') {
            $setArr["name"] = $request['name'];
            $setArr["email"] = $request['email'];
            $setArr["password"] = md5($request['password']);
            $setArr["phone"] = $request['phone'];
            $setArr["company"] = $request['company'];
            $setArr["relation"] = $request['relation'];
            $setArr["address"] = $request['address'];
            $setArr["address_country"] = $request['country'];
            $setArr["address_street"] = $request['street'];
            $setArr["address_city"] = $request['city'];
            $setArr["address_state"] = $request['state'];
            $setArr["address_zipcode"] = $request['zipcode'];
            $setArr["status"] = $request['status'];
            $setArr["dob"] = $request['dob'];
            $setArr["role_id"] = $request['role'];
            $setArr["client_user_id"] = $request['client_user_id'];

            if(isset($request['profile_image'])) {
                $fileDetail = self::returnFile();
                $requestImage = request();
                $file = $requestImage->file('profile_image');
                $fileName = $fileDetail['file_name'] .".". $file->getClientOriginalExtension();
                $filenamePath = $fileDetail['directory'] ."/". $fileName;
                $file->move($fileDetail['directory'], $filenamePath);
                $setArr["image"] =$fileName;
            }

            if( !is_array($setArr) || empty($setArr)){
                return false;
            }

            \DB::beginTransaction();
            $insertId = self::insertGetId($setArr); // Eloquent approach
            \DB::commit();
            return $insertId;
        }
    }

    public static function updateUser($request)
    {
        $setArr = [];
        if(isset($request['id']) && $request['id'] != '') {
            $setArr["name"] = $request['name'];
            $setArr["email"] = $request['email'];
            if($request['password'] !='') {
                $setArr["password"] = md5($request['password']);
            }
            $setArr["phone"] = $request['phone'];
            $setArr["company"] = $request['company'];
            $setArr["relation"] = $request['relation'];
            $setArr["address"] = $request['address'];
            $setArr["address_country"] = $request['country'];
            $setArr["address_street"] = $request['street'];
            $setArr["address_city"] = $request['city'];
            $setArr["address_state"] = $request['state'];
            $setArr["address_zipcode"] = $request['zipcode'];
            $setArr["status"] = $request['status'];
            $setArr["dob"] = $request['dob'];
            $setArr["role_id"] = $request['role'];
            $setArr["client_user_id"] = $request['client_user_id'];

            if(isset($request['profile_image'])) {
                $fileDetail = self::returnFile();
                $requestImage = request();
                $file = $requestImage->file('profile_image');
                $fileName = $fileDetail['file_name'] .".". $file->getClientOriginalExtension();
                $filenamePath = $fileDetail['directory'] ."/". $fileName;
                $file->move($fileDetail['directory'], $filenamePath);
                $setArr["image"] =$fileName;
                self::deleteImage([['id',$request["id"]]]);
            }
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

    public static function deleteUser($id)
    {
        if($id != 1) {
            $setArr = [];
            $condition = [['id',$id]];
            $dataObj = self::where($condition)->get()->first();
            if($dataObj->status == 'Disabled') {
                $setArr["status"] = 'Active';
            } else {
                $setArr["status"] = 'Disabled';
            }
            if( !is_array($setArr) || empty($setArr)){
                return false;
            }
            \DB::beginTransaction();
            self::where($condition)->update($setArr);
            \DB::commit();
            return true;
        }
        return true;
    }

    public static function resetPassword($request)
    {
        $setArr = [];
        if(isset($request['client_user_id']) && $request['client_user_id'] != '') {

            $setArr["password"] = md5($request['password']);
            if( !is_array($setArr) || empty($setArr)){
                return false;
            }
            $condition = [['id',$request["client_user_id"]]];

            \DB::beginTransaction();
            self::where($condition)->update($setArr);
            \DB::commit();
            return true;
        }

    }

    public static function returnFile()
    {
        $random_id = Lib::getToken(15);
        $file = Lib::createFile('profile', $random_id, false);
        return $file;
    }

    public static function deleteImage($condition)
    {
        $user = self::getUser($condition);
        if($user->image != '') {
            $image = base_path().'/public/profile/'. $user->image;
            if(file_exists($image)) {
                unlink($image);
            }
        }
        return true;
    }
}
