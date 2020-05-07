<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Config;
use think\Image;

class UploaderController extends Controller
{
    public function uploaderArt(Request $request){
        $validate = Config::get('image.VALIDATE');
        $path = Config::get('image.ARTPATH');
        $file = $request->file('file');
        $res = $file->validate($validate)->move($path);
        if($res){
            $fileName = $res->getPathName();
            $image = Image::open($fileName);
            $image->thumb(250,150)->save($fileName);
            $data = ['status' => 'success','info' => $fileName];
            // dump($res->getPathName());
        }else{
            // dump($file->getError());
            $data = ['status' => 'fail','info' => $file->getError()];
        }
        return json($data); 
    }

    public function uploaderPic(Request $request){
		$validate = Config::get('image.VALIDATE');
		$path = Config::get('image.ARTPIC');
		$file =  $request->file('file');
		$res  = $file->validate($validate)->move($path);
		if($res){                                                     
       			 $fileName = $res->getPathName();                      
        		$image = Image::open($fileName);                      
        		$image->thumb(920,300,Image::THUMB_FIXED)->save($fileName);              
        		$data = ['status'=>'success','info'=>$fileName];      
		}else{                                                        
        		$data = ['status'=>'fail','info'=>$file->getError()]; 
		}                                                             
		return json($data);                                           
                                                              		
		
	}
}
