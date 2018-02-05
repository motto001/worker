<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Image;
Trait Image{

public function image_upload(){ 
        if(Input::file())
        {
        $imageinputmezo=$this->TBASE['imageinputmezo'] ?? 'image' ;
        $image = Input::file($imageinputmezo);
        $imagedatamezo=$this->TBASE['imagedatamezo'] ?? 'foto' ;
        $filename=$this->TBASE['image']['name'] ?? time() . '.' . $image->getClientOriginalExtension();
        $path= $this->TBASE['image']['savepath'] ?? 'images';
        $widt=$this->TBASE['image']['widt'] ?? 600;
        $height=$this->TBASE['image']['height'] ?? 600;
        $thumb= $this->TBASE['image']['thumb'] ?? true;   

    
        $imagepath = public_path($path.'/' . $filename);
        if(!is_dir ( public_path($path) )){
            mkdir(public_path($path), 777);
            mkdir(public_path($path.'/thumb'), 777);
        }
        \Image::make($image->getRealPath())->resize($widt, $height)->save($imagepath);
        //thumb ----------------------------
        if($thumb) {         
        $th_path= $this->TBASE['image']['thumb_savepath'] ?? $path.'/thumb';
        $thumb_widt=$this->TBASE['image']['thumb_widt'] ?? 100;
        $thumb_height=$this->TBASE['image']['thumb_height'] ?? 100;
        $thumb_path = public_path($th_path.'/' . $filename);
            \Image::make($image->getRealPath())->resize($thumb_widt, $thumb_height)->save($thumb_path);
        }   

         $this->BASE['data'][$imagedatamezo]=  $th_path.'/' . $filename;
        }
           
    }

}
