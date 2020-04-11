<?php
namespace App\Repositories;

use App\Repositories\Interfaces\ImageInterface;
use Image;
use File;


class ImageRepository implements ImageInterface
{
  protected $resize;
  protected $compress;
  protected $extension;

  public function __construct()
  {
    $this->resize = 500;
    $this->compress = 80;
    $this->extension = 'jpg';
  }

  public function upload($file, $type)
  {
    $image = $file;
    $filename = str_random(20).'.'.$this->extension;
    
    //set folder upload in image and folder thumbnails
    $path = public_path().'/uploads/image/'.$type.'/'.$filename;
    $thumb = public_path().'/uploads/thumbnail/'.$type.'/'.$filename;

    try {
      //upload image and resize for thumbnails
      $thumbs_image = Image::make($image);
      $thumbs_image->resize($this->resize, $this->resize, function($constraint){
          $constraint->aspectRatio();
      })->save($thumb, $this->compress, $this->extension);
  
      //upload image with original size
      Image::make($image)->save($path, $this->compress, $this->extension);

      $result = array('status' => true, 'message' => 'uploaded', 'filename' => $filename);

    } catch (\Intervention\Image\Exception\NotReadableException $e) {
      
      $result = array('status' => false, 'message' => 'Ukuran file gambar melebihi 2Mb', 'filename' => null);
    } catch (Exception $e) {

      $result = array('status' => false, 'message' => $e, 'filename' => null);
    }
   
    return $result;
  }

  public function update($file, $oldImage, $type)
  {
    try {
      //call function delete
      $deleted = $this->delete($oldImage, $type);

      if($deleted) {
        //call function upload
        $uploaded = $this->upload($file, $type);
        
        $result = array('status' => $uploaded['status'], 'message' => $uploaded['message'], 'filename' => $uploaded['filename']);
      }else{

        $result = array('status' => $deleted['status'], 'message' => $deleted['message'], 'filename' => null);
      }

    } catch (Exception $e) {
      $result = array('status' => false, 'message' => $e, 'filename' => null);
    }
   
    return $result;
  }

  public function delete($file, $type)
  {
    try {
      //Delete image in folder uploads/image and uploads/thumbnails
      File::delete(public_path().'/uploads/image/'.$type.'/'.$file);
      File::delete(public_path().'/uploads/thumbnail/'.$type.'/'.$file);

       $result = array('status' => true, 'message' => 'deleted');
    } catch (Exception $th) {
      $result = array('status' => false, 'message' => $e);
    }
    return $result;
  }

  public function uploadContent($file, $name)
  {
    $image = $file;
    $filename = $name.'.'.$this->extension;
    
    //set folder upload in image and folder thumbnails
    $path = public_path().'/uploads/image/post/content/'.$filename;
    
    try {
      //upload image and resize for thumbnails
      $upload_image = Image::make($image);
      $upload_image->resize($this->resize * 2, $this->resize * 2, function($constraint){
          $constraint->aspectRatio();
      })->save($path, $this->compress, $this->extension);

      $result = array('status' => true, 'message' => 'uploaded', 'filename' => $filename);

    } catch (\Intervention\Image\Exception\NotReadableException $e) {
      
      $result = array('status' => false, 'message' => 'Ukuran file gambar melebihi 2Mb', 'filename' => null);
    } catch (Exception $e) {

      $result = array('status' => false, 'message' => $e, 'filename' => null);
    }
   
    return $result;
  }
}