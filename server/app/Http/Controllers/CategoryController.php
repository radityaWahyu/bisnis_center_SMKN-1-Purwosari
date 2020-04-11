<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ListCategoryResource;

class CategoryController extends Controller
{

    protected $repository;

    public function __construct(CategoryInterface $table)
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

        $row = array('limit' => $per_page, 'sort' => $sort_by, 'direction' => $direction);

        return CategoryResource::collection($this->repository->paginate($row));
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
    public function store(CategoryRequest $request)
    {
        $data = $this->repository->create($request->all());
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
        $data = $this->repository->show($id);
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message'],
            'data' => empty($data['data']) ? null : new CategoryResource($data['data'])
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
        $data = $this->repository->update($request->all(), $id);
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
        $data = $this->repository->delete($request->id);
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }

    public function listCategory()
    {
        $data = $this->repository->listCategory();

        return response()->json([
            'status' => $data['status'],
            'data' => ListCategoryResource::collection($data['data'])
        ]);
    }
}
