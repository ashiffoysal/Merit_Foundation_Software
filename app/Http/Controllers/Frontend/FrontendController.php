<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    // home page
    public function index()
    {
        return view('frontend.home.index');
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
        return view('frontend.booklesson.booklession');
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
        return view('frontend.news.index');
    }

    // cookie_policy_page
    public function cookiePolicy()
    {
        return view('frontend.pages.cookiepolicy');
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

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully'
        ]);
       
    }
    
}
