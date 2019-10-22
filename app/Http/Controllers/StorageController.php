<?php
/**
 * Created by PhpStorm.
 * User: icon
 * Date: 2019/10/21
 * Time: 下午6:47
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class StorageController extends Controller
{
    //
    function image(Request $request){
//        Log::info($request);
//        Log::info(Input::file('photo')->getClientOriginalExtension());
        $file = array(
            'images' => $request->file('photo')
        );
        // 验证条件
        // mimes:jpeg,bmp,png and for max size max:10000
        $rules = array(
            'images' => 'required'
        );
        $validator = Validator::make($file, $rules);
        if ($validator->fails()){
            return $this->returnJSON(null, 500, '图片上传失败');
        }else{
//            Log::info('validate success');
            if ($request->file('photo')->isValid()){
                $filePath = base_path("public/uploads/".date('Y-m'));
                $extension = $request->file('photo')->getClientOriginalExtension(); // 获取文件扩展名
                $fileName = rand(11111, 99999).time().".".$extension;
                $request->file('photo')->move($filePath, $fileName); // uploading file to given path
                $path = $filePath."/".$fileName;
                $im = Image::make($path);
                $quality = 70;
                $im->save($path, $quality);
                Log::info('成功上传一张图片, 路径为：'.$path);
                return $this->returnJSON([
                    'url' => env('APP_URL').'/uploads/'.date('Y-m').'/'.$fileName,
                    'info' => [
                        'len' => $im->filesize()
                    ]
                ]);
            }
        }
        return $this->returnJSON(null, 500, '图片上传失败2');
    }

    public function upload(Request $request)
    {
        $file = array(
            'images' => $request->file('photo')
        );

        $rules = array(
            'images' => 'required'
        );
        $validator = Validator::make($file, $rules);
        if ($validator->fails()){
            return ['errno'=>500, 'data'=>[], 'images不能为空'];
        }else{
            if ($request->file('photo')->isValid()){
                $filePath = base_path("public/uploads/".date('Y-m'));
                $extension = $request->file('photo')->getClientOriginalExtension(); // 获取文件扩展名
                $fileName = rand(11111, 99999).time().".".$extension;
                $request->file('photo')->move($filePath, $fileName); // uploading file to given path
                $path = $filePath."/".$fileName;
                $im = Image::make($path);
                $quality =  70;
                $im->save($path, $quality);
                Log::info('成功上传一张图片, 路径为：'.$path);
                return ['errno'=>0, 'data'=>env('APP_URL').'/uploads/'.date('Y-m').'/'.$fileName];

            }
        }
        return ['errno'=>500, 'data'=>[]];
    }

    public function file()
    {
        $file = array(
            'file' => Input::file('file')
        );
        // 设置验证条件
        // mimes:jpeg,bmp,png and for max size max:10000
        $rules = array(
            'file' => 'required'
        );
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            return $this->returnJSON(null, 500, '文件上传失败');
        } else {
            // Log::info(Input::file('file'));
            if (Input::file('file')->isValid()) {
                $destinationPath = base_path("public/uploads");
                $fileName = Input::file('file')->getClientOriginalName();

                $extension = Input::file('file')->getClientOriginalExtension(); // 获取文件扩展名
                $fileStoreName = rand(11111, 99999).time().".".$extension;

                Input::file('file')->move($destinationPath, $fileStoreName); // uploading file to given path
                return $this->returnJSON([
                    'url' => '/uploads/' . $fileStoreName,
                    'filename' =>  $fileName,
                    'value' => '/uploads/' . $fileStoreName
                ]);
            } else {
                return $this->returnJSON(null, 500, '文件上传失败');
            }
        }
    }
}
