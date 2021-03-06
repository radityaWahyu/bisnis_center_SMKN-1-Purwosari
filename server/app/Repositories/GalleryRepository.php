<?php
namespace App\Repositories;

use App\Gallery;
use App\Repositories\Interfaces\GalleryInterface;
use Illuminate\Support\Facades\Auth;

class GalleryRepository implements GalleryInterface
{

  private $table;

  public function __construct(Gallery $gallery)
  {
    $this->table = $gallery;
  }

  public function getAll(array $data)
  {
    $query = $this->table;

    if($data['type'] !== null){
      $query = $query->whereHas('categories', function($row) use ($data) {
        $row->where('categories.name', $data['type']);
      });
    }

    if(isset($data['best'])){
      $query = $query->where('is_best', 1);
    }

    if(isset($data['departement'])){
      $query = $query->where('departement', $data['departement']);
    }

    if($data['random'] == 'true'){
      $query = $query->inRandomOrder();
    } else {
      $query = $query->latest();
    }

    if(isset($data['paginate'])){
      $query = $query->paginate($data['limit']);
    }else{
      $query = $query->get();
    }
    return $query;
  }

  public function paginate(array $data)
  {

    $query = $this->table;
    $query = $query->where('item',$data['item_id'])->latest()->paginate($data['limit']);

    return $query;
  }

  public function create(array $data, $image)
  {
    try {
  
      $row = $this->table->firstOrCreate([
        'caption' => $data['caption'],
        'image' => $image,
        'item' => $data['item_id']
      ]);

      $result = array('status' => true, 'message' => 'saved');
      
    } catch (Exception $e) {

      $result = array('status'=> false, 'message'=> $e);
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

  public function show($id)
  {
    try {
      $row = $this->table;
      $row = $row->where('id',$id)->first();
      $result = array('status' => true, 'message' => 'found_row', 'data'=> $row);

    } catch (Exception $e) {
      $result = array('status' => false, 'message'=> 'not_found', 'data' => null);
    }

    return $result; 
  }
}