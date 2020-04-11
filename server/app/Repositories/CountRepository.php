<?php
namespace App\Repositories;

use App\PageCounter;
use App\Item;
use App\Post;
use App\Repositories\Interfaces\CountInterface;
use Browser;

class CountRepository implements CountInterface
{

  private $table;

  public function __construct(PageCounter $pageCounter)
  {
    $this->table = $pageCounter;
  }

  public function count(array $data)
  {

    if($data['page'] == 'news' and isset($data['slug'])) {
      $pages = 'news';
      $detail = true;
    } else if($data['page'] == 'item' and isset($data['slug']) ) {
      $pages = 'item';
      $detail = true;
    } else {
      $pages = 'pages';
      $detail = false;
    }

    try {
      $row = new $this->table;
      $row->ip_address = \Request::getClientIp(true);
      $row->browser = Browser::browserName();
      $row->type = $pages;
      $row->url = $data['path'];
      if($detail == true) {
        if($data['page'] == 'item') {
          $item = Item::where('slug', $data['slug'])->first();
          $row->view_type='App\Item';
          $row->view_id = $item['id'];
        } else if($data['page'] == 'news') {
          $item = Post::where('slug', $data['slug'])->first();
          $row->view_type='App\Post';
          $row->view_id = $item['id'];
        } 
      }
      $row->save();

      $result = array('status' => true, 'message' => 'saved');
      
    } catch (Exception $e) {

      $result = array('status'=> false, 'message'=> $e);
    }

    return $result;
  }
}