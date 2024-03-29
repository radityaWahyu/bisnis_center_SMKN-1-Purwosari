<?php
namespace App\Repositories;

use App\Category;
use App\Repositories\Interfaces\CategoryInterface;


class CategoryRepository implements CategoryInterface
{

  private $table;

  public function __construct(Category $category)
  {
    $this->table = $category;
  }

  public function getAll()
  {
    return $this->table->all();
  }

  public function paginate(array $data)
  {
    $limit = $data['limit'];
    $sort = $data['sort'];
    $direction = $data['direction'];

    return $this->table->orderBy($sort, $direction)->paginate($limit);
  }

  public function create(array $data)
  {
    try {
      $row = new $this->table;
      $row->name = $data['kategori'];
      $row->save();
      $result = array('status' => true, 'message' => 'saved');
      
    } catch (Exception $e) {

      $result = array('status'=> false, 'message'=> $e);
    }

    return $result;
  }

  public function update(array $data, $id)
  {
    try {
      $row = $this->table->find($id);
      $row->name = $data['kategori'];
      $row->save();

      $result = array('status' => true, 'message' => 'updated');

    } catch (Exception $e) {
      
      $result = array('status'=> false, 'message'=> $e);
    }

    return $result;
  }

  public function show($id)
  {
    try {
      $row = $this->table->findOrFail($id);
      $result = array('status' => true, 'message' => 'found_row', 'data'=> $row);

    } catch (Exception $e) {
      $result = array('status' => false, 'message'=> 'not_found', 'data' => null);
    }
    
   
    return $result;
  }

  public function delete($id)
  {
    
    try {
      $this->table->destroy($id);

      $result = array('status' => true, 'message' => 'deleted');

    } catch (Exception $e) {
      
      $result = array('status' => false, 'message' => $e);
    }

    return $result;
  }

  public function deleteAll(array $data)
  {

  }

  public function listCategory()
  {
    $row = $this->table->orderBy('created_at', 'desc')->get();

    if(empty($row)){
      $result = array('status' => false, 'data' => null);
    }else{
      $result = array('status' => true, 'data' => $row);
    }
    
    return $result;
  }
}