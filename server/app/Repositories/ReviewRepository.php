<?php
namespace App\Repositories;

use App\Review;
use App\Item;
use App\Repositories\Interfaces\ReviewInterface;
use Illuminate\Support\Facades\Auth;

class ReviewRepository implements ReviewInterface
{

  private $table;

  public function __construct(Review $review)
  {
    $this->table = $review;
  }

  public function getAll($id)
  {
    return $this->table
      ->where('review_id', $id)
      ->whereNull('parent_id')
      ->latest()
      ->paginate(5);
  }

  public function getLast($limit)
  {
    $user = Auth::user();
    $departement = $user['departement'];

    $query = $this->table;

    
    if($user['level'] == 'operator') {
      $query = $query->whereHas('items', function($row) use ($departement) {
            $row->where('items.departement', $departement);
          });
    }

    $query = $query->where('is_reply', 0)->whereNull('parent_id')
      ->limit($limit)
      ->latest()
      ->get();
    return $query;
  }

  public function review(array $data, $parent_id)
  {

    $user = Auth::user();

    if(isset($data['nama'])){
      $name = $data['nama'];
    }else{
      $name = $user['name'].' - '.$user['level'];
    }

    if(isset($data['phone'])){
      $phone = $data['phone'];
    }else{
      $phone = $user['phone'];
    }

    $field = [];

    try {

      $field += array(
        'name' => $name,
        'phone' => $phone,
        'message' => $data['pesan'],
        'review_id' => $data['item'],
        'review_type' => 'App\Item'
      );
      
      if(!empty($parent_id)){
        $field += array('parent_id' => $parent_id);
      }
      
      $row = $this->table->firstOrCreate($field);

      $result = array('status' => true, 'message' => 'saved');
      
    } catch (Exception $e) {

      $result = array('status'=> false, 'message'=> $e);
    }

    return $result;
  }

  public function delete($id)
  {
    try {
      
      $data = $this->table->where('parent_id', $id)->count();
      
      if($data > 0) {
        $this->table->where('parent_id', $id)->delete();
      }

      $this->table->destroy($id);

      $result = array('status' => true, 'message' => 'deleted');

    } catch (Exception $e) {
      
      $result = array('status' => false, 'message' => $e);
    }

    return $result;
  }

  public function updateReply(array $data)
  {
    try {
      $row = $this->table->find($data['id']);
      $row->is_reply = $data['is_reply'];
      $row->save();

      $result = array('status' => true, 'message' => 'updated');

    } catch (Exception $e) {
      $result = array('status' => false, 'message' => $e);
    }
  }

}