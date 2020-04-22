<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseInterface;

interface DepartementInterface extends BaseInterface
{
  public function listDepartement();
  public function findBySlug($slug);
}