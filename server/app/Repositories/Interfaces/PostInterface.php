<?php

namespace App\Repositories\Interfaces;

interface PostInterface
{
  public function getAll(array $data);
  public function paginate(array $data);
  public function create(array $data);
  public function update(array $data, $id);
  public function show($id);
  public function delete($id);
  public function setPublish($id, $value);
  public function slug($title);
  public function findBySlug($slug);
}