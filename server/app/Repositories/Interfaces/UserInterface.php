<?php

namespace App\Repositories\Interfaces;

interface UserInterface
{
  public function getAll();
  public function paginate(array $data);
  public function create(array $data);
  public function update(array $data, $id);
  public function show($id);
  public function delete($id);
  public function findUser($field, $value);
}