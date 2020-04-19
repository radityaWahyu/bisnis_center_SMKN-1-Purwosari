<?php
namespace App\Repositories;

use App\Post;
use App\Repositories\Interfaces\PostInterface;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;

class PostRepository implements PostInterface
{

  private $table;
  private $extension;

  public function __construct(Post $post)
  {
    $this->table = $post;
    $this->extension = '.jpg';
  }

  public function getAll(array $data)
  {
    $query = $this->table;

    if($data['latest'] == 'true'){
      $query = $query->latest();
    }

    if(isset($data['limit'])){
      $query = $query->limit($data['limit'])->get();
    } else{
      if(isset($data['paginate'])){
        $query = $query->paginate($data['paginate']);
      }else{
        $query = $query->get();
      }
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

  public function create(array $data)
  {
    $user = Auth::user();
    $filename = $this->slug($data['judul']).$this->extension;
    try {

      $row = $this->table->firstOrCreate([
        'title' => $data['judul'],
        'slug' => $this->slug($data['judul']),
        'content' => $data['content'],
        'departement' => $data['jurusan'],
        'user' => $user['id'],     
        'image' => $filename,
        'is_publish' => $data['publish']
      ]);

      $result = array('status' => true, 'message' => 'saved', 'filename' => $filename);
      
    } catch (Exception $e) {

      $result = array('status'=> false, 'message'=> $e);
    }

    return $result;
  }

  public function update(array $data, $id)
  {
    $user = Auth::user();
    try {
      $row = $this->table->find($id);
      $row->title = $data['judul'];
      $row->slug = $this->slug($data['judul']);
      $row->content = $data['content'];
      $row->departement = $data['jurusan'];
      $row->user = $user['id'];
      $row->is_publish = $data['publish'];

      $filename = $this->slug($data['judul']).$this->extension;

      if(!empty($image)){
        $row->image = $filename;
      }
      
      $row->save();

      $result = array('status' => true, 'message' => 'updated', 'filename' => $filename);

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

  public function setPublish($id, $value)
  {

    try {
      //find user data with custom id
      $row = $this->table->find($id);
      $row->is_publish = $value;
      $row->save();

      $result = array('status' => true, 'message' => 'updated');
      
    } catch (Exception $e) {

      $result = array('status' => false, 'message' => $e);
    }

    return $result;
  }

  public function slug($title)
  {
    $slug = str_slug($title);

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