<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function upload(Request $request)
    {
        $res = [
            'result' => 'error'
        ];

        $input = $request->all();
        $validator = \Validator::make($input, [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if($validator->fails()){
            $res['data'] = $validator->errors();
        }else{
            $photo = $request->file('photo');
            if($photo){
                $_type = (isset($input['type']) ? $input['type'] : 'profile');
                $_image_sizes = getImageSizes($_type);
                $_width = $_image_sizes['width'];
                $_height = $_image_sizes['height'];
                
                $_ext = $photo->getClientOriginalExtension();
                $_fileName = time().".$_ext";
                $_dest = "tmp/$_fileName";
                $_image = file_get_contents($photo->getRealPath());

                $_done = getPublicDisk()->put($_dest, $_image,'public');
                if($_done){
                    $res['result'] = 'ok';
                    $res['data']['name'] = $_fileName;
                    $_tmpPhoto = getPublicUrlStorage($_dest);
                    $res['data']['url'] = $_tmpPhoto;
                    try{
                        if($_width || $_height){
                            $_pathImage = getPublicPathStorage($_dest);
                            resizeImage($_pathImage,$_pathImage,$_width,$_height,91);
                        }
                    }catch(\Exception $err){
                        //var_dump($err->getMessage());exit;
                    }
                }
            }
        }

        return response()->json($res);
    }

    public function uploadVideo(Request $request)
    {
        ini_set('post_max_size', '1024M');
        ini_set('upload_max_filesize', '1024M');
        ini_set('max_input_time', 99999); //-1 is unlimited
        ini_set('max_execution_time', 0);

        $res = [
            'result' => 'error'
        ];

        $validator = \Validator::make($request->all(), [
            'file' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm,mkv|max:1024000'
        ]);

        if($validator->fails()){
            $res['data'] = $validator->errors();
        }else{
            $photo = $request->file('file');
            if($photo){
                $_ext = $photo->getClientOriginalExtension();
                $_fileName = time().".$_ext";
                $_dest = "tmp/$_fileName";
                $_video = file_get_contents($photo->getRealPath());

                $_done = getPublicDisk()->put($_dest, $_video,'public');
                if($_done){
                    $res['result'] = 'ok';
                    $res['data']['name'] = $_fileName;
                    $_tmpPhoto = getPublicUrlStorage($_dest);
                    $res['data']['path'] = $_tmpPhoto;
                }
            }
        }

        return response()->json($res);
    }

    public function uploadPhotos(Request $request)
    {
        $res = [];
        $photos = $request->file('photos');

        $input = $request->all();
        $_type = (isset($input['type']) ? $input['type'] : 'profile');
        $_image_sizes = getImageSizes($_type);
        $_width = $_image_sizes['width'];
        $_height = $_image_sizes['height'];

        foreach($photos as $key=>$photo){
            $validator = \Validator::make(['photo'=>$photo], [
                'photo' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf'
            ]);

            if($validator->fails()){
                $res['errors'][] = $validator->errors();
            }else{
                if($photo){
                    $_ext = $photo->getClientOriginalExtension();
                    $_fileName = "{$key}__".time().".$_ext";
                    $_dest = "tmp/$_fileName";
                    $_image = file_get_contents($photo->getRealPath());

                    $_done = getPublicDisk()->put($_dest, $_image,'public');
                    if($_done){
                        try{
                            if($_width || $_height){
                                $_pathImage = getPublicPathStorage($_dest);
                                resizeImage($_pathImage,$_pathImage,$_width,$_height,80);
                            }
                        }catch(\Exception $err){
                            //var_dump($err->getMessage());exit;
                        }
                        
                        $_tmpPhoto = getPublicUrlStorage($_dest);
                        $_tmp = [
                            'name' => $_fileName,
                            'path' => $_tmpPhoto
                        ];
                        $res['data'][] = $_tmp;
                    }
                }
            }
        }

        return response()->json($res);
    }


    public function removePhoto(Request $request)
    {
        $res = [
            'result' => 'error'
        ];

        $validator = \Validator::make($request->all(), [
            'photo' => 'required'
        ]);

        if($validator->fails()){
            $res['data'] = $validator->errors();
        }else{
            $photo = $request->file('photo');
            $dest    = public_path('/uploads/tmp');
            $_del_path = "$_dest/$photo";
            if(File::exists($_del_path)){
                File::delete($_del_path);
            }
        }

        return response()->json($res);
    }

    public function downloadFile(Request $request){
        $path = $request->path;
        $filename = $request->filename;
        $file = "$path/$filename";
        $url = getPathStorage($file);
        if(env('FILESYSTEM_DRIVER') == 's3'){
            $callback = function () use($file) {
                echo getDisk()->get($file);
            };

            $headers = [
                'Content-Type' => getDisk()->mimeType($file),
                'Pragma' => 'public',
                'Expires' => 0,
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Cache-Control' => 'public',
                'Content-Transfer-Encoding' => 'Binary',
                'Content-Length' => getDisk()->size($file),
                'Content-Disposition' => 'attachment; filename="'.$filename.'"'
            ];

            return response()->streamDownload($callback,$filename,$headers);
        }
        return response()->download($url);
    }
    
}
