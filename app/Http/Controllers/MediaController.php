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

        $validator = \Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if($validator->fails()){
        	$res['data'] = $validator->errors();
        }else{
        	$photo = $request->file('photo');
        	if($photo){
	            $_ext = $photo->getClientOriginalExtension();
	            $_fileName = time().".$_ext";
                $_dest = "tmp/$_fileName";

                $_setting = getSetting();
                $_width = isset($_setting['width']) ? $_setting['width'] : 150;
                $_height = isset($_setting['height']) ? $_setting['height'] : 150;
                //$_image = file_get_contents($photo->getRealPath());
                
                $_image = Image::make($photo->getRealPath());
                $_image->resize($_width, $_width, function ($constraint) {
                    $constraint->aspectRatio();                 
                })->encode($_ext,100);
                
                //$_done = getDisk()->put($_dest, $_image->__toString(),'public');
                $_done = getDisk()->put($_dest, $_image,'public');
                if($_done){
	                $res['result'] = 'ok';
	                $res['data']['name'] = $_fileName;
	                $_url = getUrlStorage($_dest);
                    $res['data']['url'] = $_url;
                    // $_fileContent = file_get_contents($_tmpPhoto);
                    // $_base64 = "data:image/$_ext;base64, ".base64_encode($_fileContent);
                    $res['data']['path'] = $_url;
	            }
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
