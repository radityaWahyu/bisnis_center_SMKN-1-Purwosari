<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\ImageInterface;
use App\Repositories\Interfaces\AuthInterface;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Browser;
use Spatie\Activitylog\Contracts\Activity;


class UserController extends Controller
{
    protected $repository;
    protected $image;
    protected $auth;
    protected $user_data;

    public function __construct(UserInterface $table, ImageInterface $image, AuthInterface $auth)
    {
        $this->repository = $table;
        $this->image = $image;
        $this->auth = $auth;
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

        return UserResource::collection($this->repository->paginate($row));
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
    public function store(UserRequest $request)
    {
        //add new data user in database
        $data = $this->repository->create($request->all());
        
        
        //check when image upload sucess
        if($data['status']) {
            //upload image in folder thumbnail and folder image
            $image = $this->image->upload($request->image, 'user', $data['filename']);

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
            'data' => empty($data['data']) ? null : new UserResource($data['data'])
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
            $upload = $this->image->update($request->file('image'), $row['data']->image, 'user', $data['filename']);
            $image = $upload['filename'];
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
                    $this->image->delete($row['data']->image, 'user');
                }
            }
        } else {
            // get user data with custom id
            $row = $this->repository->show($request->id);

            if(!empty($row['data']->image)){
                //delete image user
                $this->image->delete($row['data']->image, 'user');
            }
        }
        //delete user with custom id
        $data = $this->repository->delete($request->id);
        
        return response()->json([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credential = request(['email', 'password']);

        //Check user into system with email and password
        if(Auth::attempt($credential)){
            $token = $this->auth->grantPasswordToken($request->email, $request->password);
            $user = Auth::user();

            return response()->json([
                'status' => true,
                'user' => new UserResource($user),
                'message' => 'authenticated',
                'token' => $token->access_token,
                'expired' => $token->expires_in
            ], 200);
            
        } else {
            return response()->json([
                'status' => false,
                'message' => 'not_found'
            ]);
           
        }
        
    }

    public function logout(Request $request)
    {
       

        // unauthorized token with custom user log in
        try {
            activity()->log('logout');
           
            $token = request()->user()->token();
            $token->delete();

            // remove the httponly cookie
            cookie()->queue(cookie()->forget('refresh_token'));

            return response()->json([
                'status' => true,
                'message' => 'success log out'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ]);
        }
        
    }

    public function refreshToken(Request $request)
    {
        $response = $this->auth->refreshAccessToken();

        return response()->json([
            'status' => true,
            'token' => $response->access_token,
            'expired' => $response->expires_in,
            'message' => 'Token has been refreshed'
        ], 200);
    }

    public function getUser() 
    {
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'data' => new UserResource($user)
        ]);
    }

}
