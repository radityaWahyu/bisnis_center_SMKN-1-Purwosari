<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\ImageInterface;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemDetailResource;
use App\Http\Resources\ItemWithReviewResource;

class ItemController extends Controller
{
    protected $repository;
    protected $image;

    public function __construct(ItemInterface $table, ImageInterface $image)
    {
        $this->repository = $table;
        $this->image = $image;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = 10;
        $sort_by = "created_at";
        $direction = "desc";

        if($request->has('limit')){
            $per_page = $request('limit');
        }

        if($request->has('sort')){
            $sort_by = $request->sort;
        }

        if($request->has('direction')){
            $direction = $request->direction;
        }

        if($request->has('search')){
            $search = $request->search;
        }else{
            $search = '';
        }

        if($request->has('filter')){
            $filter = $request->filter;
        }else{
            $filter = '';
        }

        $row = array('limit' => $per_page, 'sort' => $sort_by, 'direction' => $direction, 'search' => $search, 'filter' => $filter);

        return ItemResource::collection($this->repository->paginate($row));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'message' => 'route not found'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {

        //add new data user in database
        $data = $this->repository->create($request->all());
        
        //check when image upload sucess
        if($data['status']) {
            
            //upload image in folder thumbnail and folder image
            $image = $this->image->upload($request->image, 'item', $data['filename']);

            return response()->json([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }else{
            return response()->json([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //show user data with custom id
        $data = $this->repository->show($id);
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message'],
            'data' => empty($data['data']) ? null : new ItemDetailResource($data['data'])
        ]);
    }

    public function showWithReview($id)
    {
        $data = $this->repository->show($id);
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message'],
            'data' => empty($data['data']) ? null : new ItemWithReviewResource($data['data'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            'message' => 'route not found'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       

        //update data user with new data
        $data = $this->repository->update($request->all(), $id);

         //check request image not empty array
         if($request->hasFile('image')){
            // check user have image file
            $row = $this->repository->show($id);

            // delete image and upload new image
            $upload = $this->image->update($request->file('image'), $row['data']->image, 'item', $filename);
            
        }

        return response()->json([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json([
            'message' => 'route not found'
        ]);
    }

    public function delete(Request $request)
    {

        if(is_array($request->id)) {
            foreach ($request->id as $value) {
                // get user data with custom id
                $row = $this->repository->show($value);

                if(!empty($row['data']->image)){
                    //delete image user
                    $this->image->delete($row['data']->image, 'item');
                }
            }
        } else {
            // get user data with custom id
            $row = $this->repository->show($request->id);

            if(!empty($row['data']->image)){
                //delete image user
                $this->image->delete($row['data']->image, 'item');
            }
        }
        //delete user with custom id
        $data = $this->repository->delete($request->id);
        
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }

    public function setBestItem(Request $request, $id)
    {
        $data = $this->repository->setBestItem($id, $request->is_best);

        return response()->json([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }
}
