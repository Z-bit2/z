<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class AjaxUploadController extends Controller
{
    function action(Request $request)
    {
      $validation = Validator::make($request->all(), [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,jfif|max:2048'
      ]);
      if($validation->passes())
      {
        $image = $request->file('image');
        $new_name = date('m-d-Y_hia'). rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('upload_img'), $new_name);
        return $new_name;
      }
      else
      {
        return "failed";
      }
    }
}
