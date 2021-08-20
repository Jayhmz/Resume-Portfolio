<?php

namespace App\Http\Controllers;

use App\Mail\ContactMailResponse;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //
    public function SendMessage(Request $request)
    {
      $validated = $request->validate([
        'name' => 'required|min:3',
        'email' => 'required',
        'message' => 'required'
      ]);
      $model = new Contact();
      $model->name = $request->name;
      $model->email = $request->email;
      $model->message = $request->message;

      // $details = [
      //   'title' => 'Your response was received',
      //   'body' => 'This is to show that you have successfully submitted a form from '
      // ];

      if ($validated) {
        $model->save();
        Mail::to($model->email)->send(new ContactMailResponse);
        return back()->with('success', 'Thank you for your message, an email will be sent to you shortly');
      }else{
        return back()-with('error', 'There was an error sending your message, pls try again.');
      }
    }
}
