<?php

namespace App\Repositories\Interfaces;

interface BaseInterface
{
  public function getAll();
  public function paginate(array $data);
  public function create(array $data);
  public function update(array $data, $id);
  public function show($id);
  public function delete($id);
  public function deleteAll(array $data);
}