<?php

namespace App\Repositories\Interfaces;

interface ImageInterface
{
  public function upload($file, $type);
  public function update($file, $oldImage, $type);
  public function delete($file, $type);
  public function uploadContent($file, $name);
}