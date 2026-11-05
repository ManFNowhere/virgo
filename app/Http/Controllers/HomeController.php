<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;
use App\Models\Subscription;
class HomeController extends Controller
{
    public function index(){
        $data = Movie::latest()->get()->take(7);
        $free = Movie::where("type",1)->orderBy('watched','desc')->take(7)->get();
        $paid = Movie::where('type',2)->orderBy('watched','desc')->take(7)->get();
        $watch = Movie::orderBy('watched','desc')->take(7)->get();
        return view("welcome", ["data"=>$data,"paid"=> $paid,"free"=> $free,"watch"=> $watch]);
    }
    


}
