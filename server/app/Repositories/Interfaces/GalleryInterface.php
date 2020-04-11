<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseInterface;

interface GalleryInterface
{
  public function getAll(array $data);
  public function paginate(array $data);
  public function create(array $data, $image);
  public function delete($id);
}