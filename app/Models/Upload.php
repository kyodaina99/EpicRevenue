<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

class Upload extends Model
{
    use HasFactory;

    private $fileUploadPath = '';

    private $fileManagerThumbnailSuffix = '';

    public function __construct() {
        
        $this->fileUploadPath = Config::get('constants.file_upload_path');
        $this->fileManagerThumbnailSuffix = Config::get('constants.file_manager_thumbnail_suffix');
    
    }

    public function getOriginalFileFullName() {
        return $this->file_original_name . "." . $this->extension;
    }

    public function  getImageOptimizedFullPath ($p_width = 0, $p_height = 0) {

        $width = $p_width == 0 ? 100 : $p_width;
        $height = $p_height == 0 ? 100 : $p_height;
        
        if(in_array($this->extension, array('jpeg','jpg','png','bmp'))){
            $filename = str_replace("." . $this->extension, "", $this->file_name) . "-" . $p_width . "-" . $p_height . "." . $this->extension;
            
            if (file_exists(public_path("uploads/" . $this->type . "/" . $filename))) {
                return asset("uploads/" . $this->type . "/" . $filename);
            } else {
                // Change the size of image and return it.                                
                $image = Image::make(public_path("uploads/" . $this->type . "/" . $this->file_name));
                
                if($p_width != 0 && $p_height != 0) {
                    $image->fit($width, $height);
                } else if($p_width != 0 && $p_height == 0) {
                    $image->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else if($p_width == 0 && $p_height != 0) {
                    $image->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $image->fit($width, $height);
                }
                $image->save(public_path("uploads/" . $this->type . "/" . $filename));
                return asset("uploads/" . $this->type . "/" . $this->file_name);
            }
        } else {
            return asset('images/file.svg');
        }
    }

    public function  getImageOriginFullPath () {
        if(in_array($this->extension, array('jpeg','jpg','png','bmp'))){
            return asset("uploads/" . $this->type . "/" . $this->file_name);
        } else {
            return asset('images/file.svg');
        }
    }

    public function  getFilePath () {
        return asset("uploads/" . $this->type . "/" . $this->file_name);
    }

    public function getImageOptimizedFullName($width = 0, $height = 0)
    {
        //default width
        if($width == "0" || $width =="")
        {
            $width = "100";
        }

        $filename = str_replace("." . $this->extension, "", $this->file_name) . "-" . $width . "-" . $height . "." . $this->extension;
        
        if (file_exists(public_path($this->fileUploadPath . "/" . $filename))) {
            return asset($this->fileUploadPath . "/" . $filename);
        }
        
        if (file_exists(public_path($this->fileUploadPath) . $this->type . "/" . $this->file_name) && $this->type == 'image') {                        

            $image = Image::make(public_path($this->fileUploadPath) . $this->type . "/" . $this->file_name);

            if($height == "0" || $height =="")
            {
                $ratio = $image->width() / $image->height();
                $height = floor($width / $ratio);
                $image->resize($width, $height);
            }
            else
            {
                $image->fit($width, $height);
            }

            $image->save(public_path($this->fileUploadPath) . $filename, 80);
            clearstatcache();
        } else {
            $filename = 'none.png';
        }
        
        return asset($this->fileUploadPath) . '/' . $filename;
    }

}
