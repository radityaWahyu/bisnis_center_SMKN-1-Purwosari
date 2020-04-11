<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\DepartementInterface;
use App\Http\Requests\DepartementRequest;
use App\Http\Requests\DeleteDepartementRequest;
use App\Http\Resources\DepartementResource;
use App\Http\Resources\ListDepartementResource;

class DepartementController extends Controller
{
    protected $repository;

    public function __construct(DepartementInterface $table)
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
            if($request->sort == 'departement') {
                $sort_by = 'name';
            }
        }

        if($request->has('direction')){
            $direction = $request->direction;
        }

        if($request->has('search')){
            $search = $request->search;
        }else{
            $search = '';
        }

        $row = array('limit' => $per_page, 'sort' => $sort_by, 'direction' => $direction, 'search' => $search);

        return DepartementResource::collection($this->repository->paginate($row));
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
    public function store(DepartementRequest $request)
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
    public function show($departement)
    {
        $data = $this->repository->show($departement);
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message'],
            'data' => empty($data['data']) ? null : new DepartementResource($data['data'])
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

    public function list()
    {
        $data = $this->repository->listDepartement();

        return response()->json([
            'status' => $data['status'],
            'data' => ListDepartementResource::collection($data['data'])
        ]);
        
    }
}
