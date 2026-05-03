<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    // cookie policy page
    public function cookiePolicy()
    {
        return view('frontend.pages.cookiepolicy');
    }
}
