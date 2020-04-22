<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemDetailResource;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\PostInterface;
use App\Repositories\Interfaces\CountInterface;
use App\Repositories\Interfaces\DepartementInterface;

class FrontendController extends Controller
{
    public function getItem(Request $request, ItemInterface $query)
    {
        $param = [];
        $type = null;

        if($request->has('type')){
            $type = $request->type;
        }

        if($request->has('random')){
            $param += array('random' => $request->random);
        } else {
            $param += array('random' => 'false');
        }

        if($request->has('paginate')){
            $param += array('paginate' => $request->paginate);
        }

        if($request->has('limit')){
            $param += array('limit' => $request->limit);
        }

        if($request->has('best')){
            $param += array('best' => $request->best);
        }

        if($request->has('departement')){
            $param += array('departement' => $request->departement);
        }

        $param += array('type' => $type);
       
        return ItemResource::collection($query->getAll($param));
    }

    public function getPost(Request $request, PostInterface $query)
    {
        $param = [];
        $latest = true;

        if($request->has('paginate')){
            $param += array('paginate' => $request->paginate);
        }

        if($request->has('limit')){
           $param += array('limit' => $request->limit);
        }

        $param += array('latest' => $latest);
        
        return PostResource::collection($query->getAll($param));
    }

    public function itemBySlug($slug, ItemInterface $query)
    {
        $data = $query->findBySlug($slug);
    
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message'],
            'data' => empty($data['data']) ? null : new ItemDetailResource($data['data'])
        ]);
    }

    public function postBySlug($slug, PostInterface $query)
    {
        $data = $query->findBySlug($slug);
    
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message'],
            'data' => empty($data['data']) ? null : new PostDetailResource($data['data'])
        ]);
    }

    public function departementBySlug($slug, DepartementInterface $query)
    {
        return $query->findBySlug($slug);
    }

    public function count(Request $request, CountInterface $query) {
        $path   = explode('/', $request->path);
        $params = [];
        switch ($path[1]) {
           case 'detail':
                $params += array('page' => 'item');

                if(!empty($path[2])) {
                        $params += array('slug' => $path[2]);
                }
                break;
           case 'berita':
                $params += array('page' => 'news');

                if(!empty($path[2])) {
                    $params += array('slug'=> $path[2]);
                }
                break;
           default:
                $params += array('page' => 'pages');
                break;
        }

        $params += array('path' => $request->path);
       $data = $query->count($params);

       return response()->json([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }
}
