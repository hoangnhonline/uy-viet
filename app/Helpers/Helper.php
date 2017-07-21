<?php
namespace App\Helpers;
use App\Helpers\simple_html_dom;
use App\Models\City;
use App\Models\Price;
use App\Models\Area;
use DB, Image;

class Helper
{
    public static $privateKey = 'enilnohngnaoh';

    public static function shout(string $string)
    {
        return strtoupper($string);
    }
   
    public static function showImage($image_url, $type = 'original'){

        //return strpos($image_url, 'http') === false ? config('uv.upload_url') . $type . '/' . $image_url : $image_url;        
        if(strpos($image_url, 'http') === false){
            if(strpos($image_url, 'assets') === false){
                $url = config('uv.upload_url') . $image_url;
            }else{
                $url = url('/').'/'.$image_url;
            }
            
        }else{
            $url = $image_url;   
        }
        //return strpos($image_url, 'http') === false ? config('uv.upload_url') . $image_url : $image_url;        
        return $url;

    }
    public static function showImageShop($image_url, $type = 'original'){

        //return strpos($image_url, 'http') === false ? config('uv.upload_url') . $type . '/' . $image_url : $image_url;        
        if(strpos($image_url, 'http') === false){
            if(strpos($image_url, 'assets') === false){
                $url = config('uv.upload_url_shop') . $image_url;
            }else{
                $url = url('/').'/'.$image_url;
            }
            
        }else{
            $url = $image_url;   
        }
        //return strpos($image_url, 'http') === false ? config('uv.upload_url') . $image_url : $image_url;        
        return $url;

    }
    public static function showImageThumb($image_url, $object_type = 1, $folder = ''){             
        // type = 1 : original 2 : thumbs
        //object_type = 1 : product, 2 :article  3: project             
        if(strpos($image_url, 'http') === false){
            if($object_type == 1){
                return config('uv.upload_url') . 'thumbs/' . $folder. '/' . $image_url;
            }elseif($object_type == 2){
                return config('uv.upload_url') . 'thumbs/articles/'. $folder. '/' . $image_url;
            }else{
                return config('uv.upload_url') . 'thumbs/projects/'. $folder. '/' . $image_url;
            }    
        }else{
            return $image_url;
        }
        
    }
    public static function seo(){
        $seo = [];
        $arrTmpSeo = DB::table('info_seo')->get();
        $arrSeo = $arrUrl = [];
        foreach($arrTmpSeo as $tmpSeo){
          $arrSeo[$tmpSeo->url] = ['title' => $tmpSeo->title, 'description' => $tmpSeo->description, 'keywords' => $tmpSeo->keywords, 'image_url' => $tmpSeo->image_url];
          $arrUrl[] = $tmpSeo->url;

        }
        if(in_array(url()->current(), $arrUrl)){
          $seo = $arrSeo[url()->current()];
        }
        if(empty($seo)){
          $seo['title'] = $seo['description'] = $seo['keywords'] = "Trang chủ NhaDat";
        }      
        return $seo;
    }
    
    public static function getName( $id, $table){
        $rs = DB::table($table)->where('id', $id)->first();

        return $rs ? $rs->name : "";
    }
    
    public static function parseDate($strDate){
        return mktime(1,0,0,substr($strDate,5,2), substr($strDate,8,2),substr($strDate,0,4));
    }
    public static function uploadPhoto($file, $base_folder = '', $date_dir=false){
    
        $return = [];

        $basePath = '';

        $basePath = $base_folder ? $basePath .= $base_folder ."/" : $basePath = $basePath;

        $basePath = $date_dir == true ? $basePath .= date('Y/m/d'). '/'  : $basePath = $basePath;        
        
        $desPath = config('uv.upload_path'). $basePath;
        
        //set name for file
        $fileName = $file->getClientOriginalName();
        
        $tmpArr = explode('.', $fileName);

        // Get image extension
        $imgExt = array_pop($tmpArr);

        // Get image name exclude extension
        $imgNameOrigin = preg_replace('/(.*)(_\d+x\d+)/', '$1', implode('.', $tmpArr));        

        $imgName = str_slug($imgNameOrigin, '-');
        
        $imgName = $imgName."-".time();

        $newFileName = "{$imgName}.{$imgExt}";
       //var_dump($desPath, $newFileName);die;
        if( $file->move($desPath, $newFileName) ){            
            $imagePath = $basePath.$newFileName;
            $return['image_name'] = $newFileName;
            $return['image_path'] = $imagePath;
        }

        return $return;
    }
    public static function uploadPhotoShop($file, $base_folder = '', $date_dir=false){
    
        $return = [];

        $basePath = '';

        $basePath = $base_folder ? $basePath .= $base_folder ."/" : $basePath = $basePath;

        $basePath = $date_dir == true ? $basePath .= date('Y/m/d'). '/'  : $basePath = $basePath;        

        $desPath = config('uv.upload_path_shop'). $basePath; 

        //set name for file
        $fileName = $file->getClientOriginalName();
        
        $tmpArr = explode('.', $fileName);

        // Get image extension
        $imgExt = array_pop($tmpArr);

        // Get image name exclude extension
        $imgNameOrigin = preg_replace('/(.*)(_\d+x\d+)/', '$1', implode('.', $tmpArr));        

        $imgName = str_slug($imgNameOrigin, '-');
        
        $imgName = $imgName."-".time();

        $newFileName = "{$imgName}.{$imgExt}";
       //var_dump($desPath, $newFileName);die;
        if( $file->move($desPath, $newFileName) ){            
            $imagePath = $basePath.$newFileName;
            $return['image_name'] = $newFileName;
            $return['image_path'] = $imagePath;
            $return['image_dir'] = $desPath.$newFileName;
        }

        return $return;
    }
    public static function changeFileName($str) {
        $str = self::stripUnicode($str);
        $str = str_replace("?", "", $str);
        $str = str_replace("&", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace("  ", " ", $str);
        $str = trim($str);
        $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8');
        $str = str_replace(" ", "-", $str);
        $str = str_replace("---", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('"', "", $str);
        $str = str_replace(":", "", $str);
        $str = str_replace("(", "", $str);
        $str = str_replace(")", "", $str);
        $str = str_replace(",", "", $str);
        $str = str_replace(".", "", $str);
        $str = str_replace(".", "", $str);
        $str = str_replace(".", "", $str);
        $str = str_replace("%", "", $str);
        $str = str_replace("“", "", $str);
        $str = str_replace("”", "", $str);
        return $str;
    }

    public static function stripUnicode($str) {
        if (!$str)
            return false;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '' => '?',
            '-' => '/'
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        return $str;
    }

    public static function getNextOrder($table){
        return DB::table($table)->max('col_order') + 1;
    }
}