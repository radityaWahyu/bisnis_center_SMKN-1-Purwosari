<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ReviewInterface;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    protected $repository;
    protected $image;

    public function __construct(ReviewInterface $table)
    {
        $this->repository = $table;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      return ReviewResource::collection($this->repository->getAll($request->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function review(ReviewRequest $request)
    {
      $data = $this->repository->review($request->all(), null);
      return response()->json([
          'status' => $data['status'],
          'message' => $data['message']
      ]);   
    }

    public function reply($id, Request $request)
    { 
      $data = $this->repository->review($request->all(), $id);

      $this->repository->updateReply(array('id' => $id, 'is_reply' => 1));

      return response()->json([
          'status' => $data['status'],
          'message' => $data['message']
      ]);   
    }

    public function delete(Request $request)
    {
      if($request->has('type')){
        if($request->type == 'reply'){
          $this->repository->updateReply(array('id' => $request->id_review, 'is_reply' => 0));
        }
      }

      $data = $this->repository->delete($request->id);
      
      return response()->json([
          'status' => $data['status'],
          'message' => $data['message']
      ]);
    }

    public function latest(Request $request)
    {
      $limit = 5;
      if($request->has('limit')) {
        $limit = $request->limit;
      }
      return ReviewResource::collection($this->repository->getLast($limit));
    }

}
