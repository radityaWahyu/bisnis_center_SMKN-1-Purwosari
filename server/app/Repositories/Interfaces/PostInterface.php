<?php

namespace App\Repositories\Interfaces;

interface PostInterface
{
  public function getAll(array $data);
  public function paginate(array $data);
  public function create(array $data, $image);
  public function update(array $data, $image, $id);
  public function show($id);
  public function delete($id);
  public function setPublish($id, $value);
  public function slug($title);
  public function findBySlug($slug);
}