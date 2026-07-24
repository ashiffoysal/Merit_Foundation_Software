<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Carbon\Carbon;
use App\Models\Blog;
use App\Models\BlogsCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\FeesCategory;
use App\Models\Plan;
use App\Models\BookLesson;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;
use App\Models\FreeTrial;

class FrontendController extends Controller
{
    // home page
    public function index()
    {
        $position = Location::get(request()->ip());

        return view('frontend.home.index',compact('position'));
    }
    // about page
    public function about()
    {
        return view('frontend.about.index');
    }

    // donate page
    public function donate()
    {
        return view('frontend.donate.index');
    }

    // book a lesson page
    public function bookLesson()
    {
    $feesCategory = FeesCategory::with('plans')
                    ->latest()
                    ->get();
    $allPlans=Plan::with('category')->orderBy('sort_order')->get();
        return view('frontend.booklesson.booklession', compact('feesCategory','allPlans'));
    }

    // contact us page
    public function contactUs()
    {
        return view('frontend.contactus.contact');  

    }
    // safeguard page
    public function safeguard()
    {
        return view('frontend.safeguard.index');
    }

    // privacy policy page
    public function privacyPolicy()
    {
        return view('frontend.pages.privacy');
    }


     // refund policy page
     public function refundPolicy()
     {
         return view('frontend.pages.refundpolicy');
     }

      // terms and conditions page
      public function termsAndCondition()
      {
          return view('frontend.pages.termsandcondition');
      }
    // news page
    public function news()
    {
        $firstBlogs=Blog::where('status','published')->orderBy('id','desc')->with('category')->first();
        $blogsCategory=BlogsCategory::orderBy('id','desc')->take(6)->get();
        $allBlogs=Blog::where('status','published')->orderBy('id','desc')->with('category')->skip(1)->paginate(6);
        $mostRecent=Blog::where('status','published')->orderBy('id','desc')->with('category')->skip(6)->take(5)->get();
        return view('frontend.news.index',compact('allBlogs','firstBlogs','blogsCategory','mostRecent'));
    }

    public function newsDetails($slug)
    {
        $blog=Blog::where('slug',$slug)->with('category')->firstOrFail();
        $recentBlogs=Blog::where('status','published')->orderBy('id','desc')->with('category')->take(5)->get();
        return view('frontend.news.details',compact('blog','recentBlogs'));
    }
    // cookie_policy_page
    public function cookiePolicy()
    {
        return view('frontend.pages.cookie_policy');
    }
    // 
    public function contactSubmt(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name'   => 'required|max:100',
            'last_name'    => 'required|max:100',
            'email'        => 'required|email',
            'phone'        => 'nullable|max:30',
            'enquiry_type' => 'required',
            'message'      => 'required|min:10',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }
        $insert=ContactMessage::insertGetId([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'enquiry_type' => $request->enquiry_type,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            
        ]);
        $data=ContactMessage::find($insert);
        Mail::to('info@meriteducationfoundation.org')->send(new ContactMessageMail($data));

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully'
        ]);
       
    }

    // checkout page/form page
    public function checkout(Request $request)
    {
         $plan = $request->plan;
        $allPackage=Plan::with('category')->orderBy('sort_order')->get();
        return view('frontend.booklesson.checkout', compact('plan', 'allPackage'));
   

    }

    public function checkoutstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_name'        => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'package_id'          => 'required|exists:plans,id',
            'phone'              => 'required|string|max:30',
            'emergency_phone'    => 'nullable|string|max:30',
            'address'            => 'required|string|max:500',
            'post_code'          => 'required|string|max:20',
            'student_first_name' => 'required|string|max:255',
            'student_last_name'  => 'required|string|max:255',
            'current_level'      => 'nullable|in:Complete Beginner,Qaida / Basics,Reading Quran,Tajweed,Hifz (Memorisation)',
            'preferred_tutor'    => 'required|in:Not Specified,Male Tutor,Female Tutor',
            'preferred_time'     => 'required|in:Morning (8am–12pm),Afternoon (12pm–5pm),Evening (5pm–9pm),Weekend only,Flexible — any time',
            'notes'              => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        BookLesson::create([
            'parent_name'        => $request->parent_name,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'emergency_phone'    => $request->emergency_phone,
            'address'            => $request->address,
            'post_code'          => $request->post_code,
            'student_first_name' => $request->student_first_name,
            'student_last_name'  => $request->student_last_name,
            'current_level'      => $request->current_level,
            'preferred_tutor'    => $request->preferred_tutor,
            'preferred_time'     => $request->preferred_time,
            'notes'              => $request->notes,
            'package_id'            => $request->package_id,
            'donation_interest'  => false,
            'status'             => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully'
        ]);
    }
    // book free trial page
    public function bookFreeTrial()
    {
       
        return view('frontend.bookfreetrial.index');
    }


    // 
    public function bookFreeTrialsubmit(Request $request)
{
    
    $validated = $request->validate([

        'parent_name'=>'required|max:100',

        'child_name'=>'required|max:100',

        'child_age'=>'required',

        'current_level'=>'required',

        'tutor_gender'=>'required',

        'country'=>'required|max:100',

        'email'=>'required|email',

        'whatsapp'=>'required|max:20',

        'time'=>'required',


    ]);

    // Save Data

     FreeTrial::insert([
        'parent_name'=>$request->parent_name,
        'child_name'=>$request->child_name,
        'child_age'=>$request->child_age,
        'current_level'=>$request->current_level,
        'tutor_gender'=>$request->tutor_gender,
        'country'=>$request->country,
        'email'=>$request->email,
        'whatsapp'=>$request->whatsapp,
        'time'=>$request->time,
        'created_at'=>Carbon::now()->toDateTimeString(),

     ]);

    return response()->json([

        'status'=>true,

        'message'=>'Your free trial request has been submitted successfully! We will contact you shortly.'

    ]);

}

// admission procedure
    public function admissionProcedure(){
        return view('frontend.admission.index');
    }
}
