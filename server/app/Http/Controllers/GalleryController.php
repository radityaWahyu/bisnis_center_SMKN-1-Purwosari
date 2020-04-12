<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\GalleryInterface;
use App\Repositories\Interfaces\ImageInterface;
use App\Http\Requests\GalleryRequest;
use App\Http\Resources\GalleryResource;

class GalleryController extends Controller
{
    protected $repository;
    protected $image;

    public function __construct(GalleryInterface $table, ImageInterface $image) {
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
        $limit = 8;

        return GalleryResource::collection($this->repository->paginate(array('limit' => $limit, 'item_id' => $request->item_id)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        //upload image in folder thumbnail and folder image
        $image = $this->image->upload($request->image, 'gallery');
        
        //check when image upload sucess
        if($image['status']) {
            //add new data user in database
            $data = $this->repository->create($request->all(), $image['filename']);
            return response()->json([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }else{
            return response()->json([
                'status' => $image['status'],
                'message' => $image['message']
            ]);
        }
    }

    public function delete(Request $request)
    {
        if(is_array($request->id)) {
            foreach ($request->id as $value) {
                // get user data with custom id
                $row = $this->repository->show($value);

                if(!empty($row['data']->image)){
                    //delete image user
                    $this->image->delete($row['data']->image, 'gallery');
                }
            }
        } else {
            // get user data with custom id
            $row = $this->repository->show($request->id);

            if(!empty($row['data']->image)){
                //delete image user
                $this->image->delete($row['data']->image, 'gallery');
            }
        }
        //delete user with custom id
        $data = $this->repository->delete($request->id);
        
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
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
            'data' => empty($data['data']) ? null : new GalleryResource($data['data'])
        ]);
    }
}
