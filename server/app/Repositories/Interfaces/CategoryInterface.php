<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseInterface;

interface CategoryInterface extends BaseInterface
{
  public function listCategory();
}