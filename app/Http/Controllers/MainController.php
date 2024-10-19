<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\course;
use App\Models\category;
use App\Models\User;

class MainController extends Controller
{
     public function index()
    {
        $categories= category::latest()->take(5)->get();
        $latest_courses = course::latest()->take(3)->get();
        $courses = course::all();
        return view('front.index',compact('categories','courses','latest_courses'));
    }



    public function category($slug)
    {
        $category=category::where('slug',$slug)->first();
        $title=$category->trans_name;
        // dd($category);
        $courses= course::where('category_id',$category->id)->paginate(6);
        // dd($courses);
        return view('front.courses',compact('title','courses'));
    }

    public function about()
    {
        return view('front.about') ;
    }

    public function contact()
    {
        return view('front.contact') ;
    }

    public function courses()
    {
        // $category=category::where('slug',$slug)->first();

        $title='All Courses';
        $courses= course::paginate(6);
        return view('front.courses',compact('title','courses'));
    }

    public function courses_single($slug)
    {
        $course = course::with('videos','category')->withCount('videos')->where('slug',$slug)->firstOrFail();
        $related_courses= course::where('category_id',$course->category_id)
        ->where('id','<>',$course->id)
        ->latest()
        ->limit(3)
        ->get();
        return view('front.courses_single', compact('course','related_courses'));
    }

    public function login()
    {
        return view('front.login') ;

    }
    public function buy_course(course $course)
    {
        return view('front.buy_course', compact('course') ) ;
    }
    //  public function buy_course(course $course)
    //  {
    //     $price = $course->price;
    //     $discount= $price * ($course->discount /100);
    //     $total = $price - $discount;
    //     $url = "https://eu-test.oppwa.com/v1/checkouts";
    //     $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
    //                 "&amount=" .$total.
    //                 "&currency=USD" .
    //                 "&paymentType=DB".
    //                 "&integrity=true";

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //                 'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $responseData = curl_exec($ch);
    //     if(curl_errno($ch)) {
    //         return curl_error($ch);
    //     }
    //     curl_close($ch);
    //     $responseData = json_decode($responseData, true);
    //     $checkoutId = $responseData ['id'];
    //     $integrity = $responseData ['integrity'];
    //     return view('front.buy_course',compact('course','checkoutId','integrity'));
    //  }

     public function buy_course_thanks (Request  $request)
     {
        $course = Course::where('id',$request->id)->firstOrFail();
                $price = $course->price;
                $discount= $price * ($course->discount /100);
                $total = $price - $discount;
        Stripe::setApiKey(env('STRIPE_SECRET'));

            $charge = Charge::create([
                'amount' => $total * 100 , // Amount in cents (e.g., $50.00)
                'currency' => 'usd',
                'description' => $course->trans_name,
                'source' => $request->stripeToken,
            ]);
            $status = $charge->status;
            if($status ==  'succeeded' ){

                //register product

                DB::table('user_courses')->insert([
                    'user_id'=>Auth::id(),
                    'course_id'=>$course->id
                ]);

                //show success massage
                return redirect()->route('website.courses_single', $course->slug)
                     ->with('msg', 'Payment success')
                     ->with('type', 'success');
            }else{

            //show error massage
            return redirect()->route('website.courses_single', $course->slug)
            ->with('msg', 'Payment failed')
            ->with('type', 'danger');

            }

     }

}
