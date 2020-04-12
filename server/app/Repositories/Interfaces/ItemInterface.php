<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseInterface;

interface ItemInterface
{
  public function getAll(array $data);
  public function paginate(array $data);
  public function create(array $data, $image);
  public function update(array $data, $image, $id);
  public function show($id);
  public function delete($id);
  public function setBestItem($id, $value);
  public function slug($slug);
  public function findBySlug($slug);
}