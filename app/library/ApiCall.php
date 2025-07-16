<?php
namespace App\library;
use App\Model\OdaCountry;

class ApiCall {
    public static function execute($url, $method, $requestParam, $header , $returnObj=true)
    {
        $userArr = request()->session()->get('client_user');
      //  dd($requestParam);

        if(isset($userArr["id"]) && $userArr["client_masters_id"]  && !isset($requestParam["client_masters_id"]) ) {
            $requestParam["client_user_id"] = $userArr["id"];
            $requestParam["client_master_id"]  =$requestParam["client_masters_id"] = $userArr["client_masters_id"];        
        }
        if(request()->session()->has('selectedGlobalBranchId')) {
            $requestParam["selectedBranchId"] = request()->session()->get('selectedGlobalBranchId');
        }
        if(request()->session()->has('selectedGlobalCountryId')) {
            $requestParam["selectedGlobalCountryId"] = request()->session()->get('selectedGlobalCountryId');
           // $token = env('IP_TOKEN');
            //$ipInfo = file_get_contents('http://ipinfo.io/');
                //$ipInfo = json_decode($ipInfo);
                //$timezone = $ipInfo->timezone;
            $timezone = "Asia/Riyadh";
            date_default_timezone_set($timezone);
            $requestParam["selectedTimeZone"] = $timezone;
            $requestParam["selectedTime"] = date('Y/m/d H:i:s');
        }

        try {
                 $curl = curl_init();
                 curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => json_encode($requestParam),
                CURLOPT_HTTPHEADER => $header,
            ));
            $response = curl_exec($curl);

            if($returnObj) {
                $error = self::isErrorResponse($response);
                
                if(is_array($error) ){
                    return $error;
                }
            }
          
            $err = curl_error($curl);
            curl_close($curl);
            if ($err ) {
                return ["Error"=> $err];
            } else if(self::isJson($response)){
                if($returnObj) {
                    return json_decode($response);
                }
                return json_decode($response, 1);
            }
            return $response;
        }
        catch(\Exception $ex){
            return ["Error"=> $ex->getMessage()];
        }
    }
    public static function setErrorForView($resultSet=[]){

        if( isset($resultSet["error"]) ) {           
            $errors = new \Illuminate\Support\MessageBag();

            if( is_array( $resultSet["error"]) ) {        
                foreach($resultSet["error"] as $field=>$arr){
                    if( is_array($arr) && isset( $arr [0] ) ) {
                        $errors->add( $field,  $arr[0]);
                    }
                    else{
                        $errors->add( $field,  $arr);
                    }
                }                
            }
            else{
                $errors->add( 'msg',  $resultSet["error"] );
            }
            return $errors;
        }

    }
    public static function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    public static function createThumbsByDirectory( $pathToImages, $pathToThumbs, $thumbWidth ) 
    {
        // open the directory
        $dir = opendir( $pathToImages );

        // loop through it, looking for any/all JPG files:
        while (false !== ($fname = readdir( $dir ))) {
            // parse path for the extension
            $info = pathinfo($pathToImages . $fname);            
           
            // continue only if this is a JPEG image
            if ( strtolower($info['extension']) == 'jpg' ) 
            { 
                // load image and get image size
                $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
                $width = imagesx( $img );
                $height = imagesy( $img );

                // calculate thumbnail size
                $new_width = $thumbWidth;
                $new_height = floor( $height * ( $thumbWidth / $width ) );

                // create a new temporary image
                $tmp_img = imagecreatetruecolor( $new_width, $new_height );

                // copy and resize old image into new image 
                imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

                // save thumbnail into a file
                imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
            }
        }
        // close the directory
        closedir( $dir );
    }
    public static function reCreateImages($pathToImages, $pathToThumbs, $thumbWidth, $tail){
        $info = pathinfo($pathToImages );       
        $extension = strtolower($info['extension']);
        if ($extension == 'gif') {
			$imgt = "ImageGIF";
			$imgcreatefrom = "ImageCreateFromGIF";
		}else if($extension == 'jpg' || $extension == 'jpeg'){
			$imgt = "ImageJPEG";
			$imgcreatefrom = "ImageCreateFromJPEG";
		}else if ($extension == 'png') {
			$imgt = "ImagePNG";
			$imgcreatefrom = "ImageCreateFromPNG";
        }
        
        // continue only if this is a JPEG image
        if ( isset($imgt) ) {
            // load image and get image size            
            $img = $imgcreatefrom( $pathToImages);
            $width = imagesx( $img );
            $height = imagesy( $img );

            // calculate thumbnail size
            $new_width = $thumbWidth;
            $new_height = floor( $height * ( $thumbWidth / $width ) );

            // create a new temporary image
            $tmp_img = imagecreatetruecolor( $new_width, $new_height );
            
            if($extension == 'png'){
				// Disable alpha mixing and set alpha flag if is a png file
				imagealphablending($tmp_img, false);
				imagesavealpha($tmp_img, true);
			}
            // copy and resize old image into new image 
            imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

            // save thumbnail into a file
            $imgt( $tmp_img, "{$pathToThumbs}{$info['filename']}{$tail}.{$extension}" );
            $web_path = \Config::get('constants.website_path') ?? '';
            if($web_path != '') {
                $uploadWebImage =  $web_path . 'uploads/product_images/';
                $imgt( $tmp_img, "{$uploadWebImage}{$info['filename']}{$tail}.{$extension}" );
            }

        }
    }

    public static function isErrorResponse($response){
        $tmp = json_decode($response,1);
        if( isset($tmp["error"]) ) {
            $errors = new \Illuminate\Support\MessageBag( );
            if( isset($tmp["data"]) && is_array( $tmp["data"]) ) {
                foreach($tmp["data"] as $field=>$arr){
                    $errors->add( $field,  $arr[0]);
                }
            }
            else{
                $errors->add( 'msg',  $tmp["error"] );
            }
            return ["is_error" => true, "errors" => $errors  ];
        }
        return false;
    }
   
    public static function createThumbAndLargeImages($pathToImages, $pathToThumbs){
        try{
            self::reCreateImages($pathToImages, $pathToThumbs, 150, "_thumb");
            self::reCreateImages($pathToImages, $pathToThumbs, 350, "_large");
            return true;
        }
        catch(\Exception $e){
            return false;
        }

    }

    public function redimesionImage($endThu,$newX,$newY,$endImg,$fileType){

        copy( $endThu, $endImg );
    
        list( $width, $height ) = getimagesize( $endImg );
    
        if($width >= $height) {
    
            $newXimage = $newX;
    
            $newYimage = ($height / $width) * $newXimage;
    
        } else {
    
            $newYimage = $newY;
    
            $newXimage = ($width / $height) * $newYimage;
        }
    
        $imageInicial = imagecreatetruecolor(ceil($newXimage), ceil($newYimage));
    
        if ($fileType == 'jpeg')   $endereco = imagecreatefromjpeg($endImg);
        if ($fileType == 'jpg')  $endereco = imagecreatefromjpeg($endImg);      
        if ($fileType == 'png') {
            $endereco = imagecreatefrompng($endImg);
            imagealphablending($imageInicial, false);
            imagesavealpha($imageInicial,true);
            $transparent = imagecolorallocatealpha($imageInicial, 255, 255, 255, 127);
            imagefilledrectangle($endereco, 0, 0, $newXimage, $newYimage, $transparent);
        }
        if ($fileType == 'gif')  {
            $endereco = imagecreatefromgif($endImg);
            $this->setTransparency($imageInicial,$endereco);
        }
    
        imagecopyresampled($imageInicial, $endereco, 0, 0, 0, 0, ceil($newXimage), ceil($newYimage), ceil($width), ceil($height));
    
        if ($fileType == 'jpeg') imagejpeg($imageInicial, $endImg, 100);
        if ($fileType == 'jpg') imagejpeg($imageInicial, $endImg, 100);
        if ($fileType == 'png') imagepng($imageInicial, $endImg, 9);
        if ($fileType == 'gif') imagegif($imageInicial, $endImg, 100);
    }
    private function setTransparency($new_image,$image_source){ 
        $transparencyIndex = imagecolortransparent($image_source); 
        $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);     
        if($transparencyIndex >= 0){
            $transparencyColor = imagecolorsforindex($image_source, $transparencyIndex);    
        }
        $transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']); 
        imagefill($new_image, 0, 0, $transparencyIndex); 
        imagecolortransparent($new_image, $transparencyIndex);        
    }


    public static function checkValidation( $clientMasterColumnName = 'client_master_id', $isOnlyActiveFlagNeeded = false, $isNondisabledStatusFlag=false){
        $userArr = request()->session()->get('client_user');
        $requestParam=[];
        if(isset($userArr["id"]) && $userArr["client_masters_id"] && !isset($requestParam["client_master_id"]) ) {
            $requestParam []= [$clientMasterColumnName , $userArr["client_masters_id"]];
        }
        if(request()->session()->has('selectedGlobalCountryId')) {
            $requestParam []=["country_id", request()->session()->get('selectedGlobalCountryId') ];
        }
        if(request()->session()->has('selectedGlobalBranchId') && request()->session()->get('selectedGlobalBranchId') != 1) {
            $requestParam []= ["location_id", request()->session()->get('selectedGlobalBranchId') ];
        }
        if( $isNondisabledStatusFlag ) {
            $requestParam []= ["status", '<>', 'Disabled' ];
        }
        if( $isOnlyActiveFlagNeeded  ) {
            $requestParam []= ["status",'Active'];
        }
        return $requestParam;
    }

}