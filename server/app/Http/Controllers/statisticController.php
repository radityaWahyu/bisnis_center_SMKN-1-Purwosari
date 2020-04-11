<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\Item;
use App\PageCounter;


class statisticController extends Controller
{
    public function count(Request $request)
    {
        $user = Auth::user();
        if($request->has('type')) {
            switch ($request->type) {
                case 'user':
                    if($user['level'] == 'admin') {
                        $data = User::count();
                    }else{
                        $data = 0;
                    }
                    break;
                
                case 'produk':
                    if($user['level'] == 'admin') {
                        $data = Item::count();
                    }else{
                        $data = Item::where('departement', $user['departement'])->count();
                    }
                    break;
                
                case 'berita':
                    if($user['level'] == 'admin') {
                        $data = Post::count();
                    }else{
                        $data = Post::where('departement', $user['departement'])->count();
                    }
                    break;
            }

            return response()->json([
                'status' => true,
                'message' => 'success',
                'count' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'type not found',
                'count' => 0
            ]);
        }
    }

    public function chart(Request $request) {
       
        $viewing_count = [];
        $date_viewing = [];
        $view = [];
        $series = [];
        $count2=[];
        $count3=[];
        
        if($request->has('type')){
            switch ($request->type) {
                case 'month':
                    $page_view = PageCounter::selectRaw('count(*) as view_count, DATE_FORMAT(created_at, "%Y-%m") as day');
                    $dates = $this->getMonth();
                    break;
                
                default:
                    $dates = $this->getDay();
                    $page_view = PageCounter::selectRaw('count(*) as view_count, DATE(created_at) as day');
                    break;
            }
        }

        $page_view = $page_view->groupBy('day')->get();
     
        foreach ($page_view as $key => $value) {
            $viewing_count= $viewing_count + array($value->day => $value->view_count);
        }
        
        for ($i=0; $i < count($dates) ; $i++) {
            if(array_key_exists($dates[$i], $viewing_count)){
                array_push($count3, $viewing_count[$dates[$i]]);
            }else{
                array_push($count3, 0);
            }
        }
       
        $view = ['name'=>'Pengunjung','data'=>$count3];

        array_push($series, $view);

        return response()->json([
            'status' => 'success',
            'message' => 'chart generate',
            'series' => $series,
            'categories' => $dates
        ],200);
    }

    public function getDay(){
        $today = today(); 
        $dates = []; 

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
        }

        return $dates;
    }

    public function getMonth(){
        $months = [];

        for($m=1; $m<=12; ++$m){
            array_push($months, date('Y-m', mktime(0, 0, 0, $m, 1)));
        }

        return $months;
    }
}
