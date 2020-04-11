<?php

namespace App\Repositories\Interfaces;

interface ReviewInterface
{
  public function getAll($item_id);
  public function getLast($limit);
  public function review(array $data, $parent_id);
  public function updateReply(array $data);
  public function delete($id);
}