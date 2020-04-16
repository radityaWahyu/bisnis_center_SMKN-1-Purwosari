<?php
namespace App\Repositories;

use App\Item;
use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Support\Facades\Auth;

class ItemRepository implements ItemInterface
{

  private $table;

  public function __construct(Item $item)
  {
    $this->table = $item;
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
    $user = Auth::user();

    $limit = $data['limit'];
    $sort = $data['sort'];
    $direction = $data['direction'];

    $query = $this->table->withCount([
      'reviews as review_count',
      'viewers as view_count'
    ]);

    // check where user level operator or admin
    if($user['level'] == 'operator'){
      $query = $query->where('user', $user['id']);
    }

    if(!empty($data['search'])){
      $query = $query->where('title','LIKE',"%".$data['search']."%");
    }

    if(!empty($data['filter'])){
      $query = $query->where('departement', $data['filter']);
    }

    $query = $query->orderBy($sort, $direction)->paginate($limit);

    return $query;
  }

  public function create(array $data, $image)
  {
    $user = Auth::user();
    try {
      $row = new $this->table;
      $row->title = $data['judul'];
      $row->slug = $this->slug($data['judul']);
      $row->description = $data['deskripsi'];
      $row->category = $data['kategori'];
      $row->departement = $data['jurusan'];
      $row->user = $user['id'];
      $row->image = $image;
      $row->save();

      $result = array('status' => true, 'message' => 'saved');
      
    } catch (Exception $e) {

      $result = array('status'=> false, 'message'=> $e);
    }

    return $result;
  }

  public function update(array $data, $image, $id)
  {
    $user = Auth::user();
    try {
      $row = $this->table->find($id);
      $row->title = $data['judul'];
      $row->slug = $this->slug($data['judul']);
      $row->description = $data['deskripsi'];
      $row->category = $data['kategori'];
      $row->departement = $data['jurusan'];
      $row->user = $user['id'];    

      if(!empty($image)){
        $row->image = $image;
      }
      
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
      $row = $this->table->withCount([
        'reviews as review_count',
        'viewers as view_count'
      ]);
      $row = $row->where('id',$id)->first();
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

  public function setBestItem($id, $value)
  {

    try {
      //find user data with custom id
      $row = $this->table->find($id);
      $row->is_best = $value;
      $row->save();

      $result = array('status' => true, 'message' => 'updated');
      
    } catch (Exception $e) {

      $result = array('status' => false, 'message' => $e);
    }

    return $result;
  }

  public function slug($slug)
  {
    $slug = str_slug($slug);

    //find slug into database
    $allSlug = $this->table->where('slug','like', $slug.'$')->get();

    if(!$allSlug->contains('slug', $slug)){
      return $slug;
    }else{
      for ($i = 1; $i <= 10; $i++) {
        $newSlug = $slug.'-'.$i;

        if (!$allSlugs->contains('slug', $newSlug)) {
            return $newSlug;
        }
      }
    }
  }

  public function findBySlug($slug)
  {
    try {
      $row = $this->table->where('slug', $slug)->firstOrFail();

      $result = array('status' => true, 'message' => 'found_row', 'data'=> $row);
    } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      
      $result = array('status' => false, 'message'=> 'not_found', 'data' => null);
    }

    return $result;
  }
}