<?php

namespace App\Http\Controllers;

use Stripe\Webhook;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Charge;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\course;
use App\Models\category;
use App\Models\User;
// use Stripe\Webhook;

class MainController extends Controller
{
    public function index()
    {
        $categories = category::latest()->take(5)->get();
        $latest_courses = course::latest()->take(3)->get();
        $courses = course::all();
        return view('front.index', compact('categories', 'courses', 'latest_courses'));
    }



    public function category($slug)
    {
        $category = category::where('slug', $slug)->first();
        $title = $category->trans_name;
        // dd($category);
        $courses = course::where('category_id', $category->id)->paginate(6);
        // dd($courses);
        return view('front.courses', compact('title', 'courses'));
    }

    public function about()
    {
        return view('front.about');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function courses()
    {
        // $category=category::where('slug',$slug)->first();

        $title = 'All Courses';
        $courses = course::paginate(6);
        return view('front.courses', compact('title', 'courses'));
    }

    public function courses_single($slug)
    {
        $course = course::with('videos', 'category')->withCount('videos')->where('slug', $slug)->firstOrFail();
        $related_courses = course::where('category_id', $course->category_id)
            ->where('id', '<>', $course->id)
            ->latest()
            ->limit(3)
            ->get();
        return view('front.courses_single', compact('course', 'related_courses'));
    }

    public function login()
    {
        return view('front.login');

    }
    public function buy_course(course $course)
    {
        $price = $course->price;
        $discount = $price * ($course->discount / 100);
        $total = $price - $discount;
        return view('front.buy_course', compact('course', 'total'));
    }

    public function buy_course_thanks(Request  $request)
    {
        $course = Course::where('id', $request->id)->firstOrFail();
        $price = $course->price;
        $discount = $price * ($course->discount / 100);
        $total = $price - $discount;
        Stripe::setApiKey( env('STRIPE_SECRET'));

        $checkout_session  = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $course->trans_name,
                    ],
                    'unit_amount' => $total * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('website.courses_single', $course->slug),
            'cancel_url' => route('website.courses_single', $course->slug),
        ]);
        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);
        // dd( $checkout_session);
        return redirect($checkout_session->url);
    }




    public function handleWebhook(Request $request)
    {
        $course = Course::where("id", $request->id)->firstOrFail();
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Your webhook secret (to verify the webhook signature)
        $endpointSecret = env('stripe_webhook_secret ');

        // Get the Stripe signature header
        $sigHeader = $request->header('Stripe-Signature');

        $payload = $request->getContent();

        try {
            // Verify the webhook signature
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid Payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid Signature'], 400);
        }
        $type = $event->type;
        if ($type == 'charge.updated') {
            DB::table('user_courses')->insert([
                'user_id' => Auth::id(),
                'course_id' => $course->id
            ]);
        }else {
            return redirect()->route('website.buy_course')->with('error','failed');
        }

        // Handle the event
        //     switch ($event->type) {
        //         case 'payment_intent.succeeded':
        //             $paymentIntent = $event->data->object; // contains a StripePaymentIntent object
        //             // Handle successful payment here
        //             DB::table('user_courses')->insert([
        //                 'user_id'=>Auth::id(),
        //                 'course_id'=>$course->id
        //             ]);
        //         break;

        //         case 'charge.refunded':
        //             $charge = $event->data->object; // contains a StripeCharge object
        //             // Handle charge refund here
        //             Log::info('Charge refunded for ID: ' . $charge->id);
        //             break;

        //         // Handle other event types as needed
        //         default:
        //             Log::warning('Received unknown event type ' . $event->type);
        //     }

        //     return response()->json(['status' => 'success'],200);
    }
}
