<?php

namespace App\Repositories\Interfaces;

interface ImageInterface
{
  public function upload($file, $type, $filename);
  public function update($file, $oldImage, $type, $filename);
  public function delete($file, $type);
  public function uploadContent($file, $name);
}