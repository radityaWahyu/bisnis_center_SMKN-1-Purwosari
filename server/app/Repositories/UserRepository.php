<?php
namespace App\Repositories;

use App\User;
use App\Repositories\Interfaces\UserInterface;
use Hash;
use Illuminate\Support\Str;

class UserRepository implements UserInterface
{

  private $table;
  private $extension;

  public function __construct(User $user)
  {
    $this->table = $user;
    $this->extension = 'jpg';
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

    $query = $this->table;

    if(!empty($data['search'])){
      $query = $query->where('name','LIKE',"%".$data['search']."%");
    }

    if(!empty($data['filter'])){
      $query = $query->where('departement', $data['filter']);
    }

    $query = $query->orderBy($sort, $direction)->paginate($limit);

    return $query;
  }

  public function create(array $data)
  {
    $field = [];
    $filename = Str::slug($data['nama'],'_').$this->extension;
    try {

      $field += array(
        'name' => $data['nama'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'level' => $data['level'],
        'phone' => $data['phone'],
        'image' => $filename
      );

     
      if(isset($data['jurusan'])){
        $field += array('departement' => $data['jurusan']);
      }
     
      $row = $this->table->firstOrCreate($field);

      $result = array('status' => true, 'message' => 'saved', 'filename' => $filename);
      
    } catch (Exception $e) {

      $result = array('status'=> false, 'message'=> $e);
    }

    return $result;
  }

  public function update(array $data, $id)
  {
    try {
      $row = $this->table->find($id);
      $row->name = $data['nama'];
      $row->email = $data['email'];

      if(!empty($data['password'])){
        $row->password = Hash::make($data['password']);
      }
      
      $row->level = $data['level'];

      if(isset($data['jurusan'])){
        $row->departement = $data['jurusan'];
      }
      $filename = Str::slug($data['nama'],'_').$this->extension;

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

  public function findUser($field, $value)
  {
    return "found";
  }
}