<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    //contact message index
    public function index()
    {     $contactMessages = ContactMessage::latest()->get();
        return view('backend.contact_messages.index', compact('contactMessages'));
    }
    // contact message show
    
}
