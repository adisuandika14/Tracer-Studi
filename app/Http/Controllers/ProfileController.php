<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    // public function show(){
    //     $profile = admins::all();
    //     return view('/auth/admin')

    // }

    public function profile(Request $request)
    {
        $profile = User::all();
        return view('/auth/admin/profile', compact('profile'));
    }

    public function update(Request $request){
        $profile = NULL;
        $profile = User::find($request->id);
        //$profile->name = $request->name;
        //$profile->nama_depan = $request->nama_depan;
        //$profile->nama_belakang = $request->nama_belakang;
        //$profile->email = $request->email;
        // $profile->save();
        //$profile->no_tlp = $request->no_tlp;

        $file = $request->file('file');
 
      	        // nama file
		echo 'File Name: '.$file->getClientOriginalName();
		echo '<br>';
 
      	        // ekstensi file
		echo 'File Extension: '.$file->getClientOriginalExtension();
		echo '<br>';
 
      	        // real path
		echo 'File Real Path: '.$file->getRealPath();
		echo '<br>';
 
      	        // ukuran file
		echo 'File Size: '.$file->getSize();
		echo '<br>';
 
      	        // tipe mime
		echo 'File Mime Type: '.$file->getMimeType();
 
      	        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_file';
 
                // upload file
		$file->move($tujuan_upload,$file->getClientOriginalName());

        
        //return response()->json(['success'=>'success']);
       return redirect('/admin/auth/profile')->with('success','Data berhasil diupdate!');

    }

    // public function upload(Request $request)
    // {
    //     $folderPath = public_path('upload/');

    //     $image_parts = explode(";base64,", $request->image);
    //     $image_type_aux = explode("image/", $image_parts[0]);
    //     $image_type = $image_type_aux[1];
    //     $image_base64 = base64_decode($image_parts[1]);
    //     $file = $folderPath . uniqid() . '.jpg';

    //     file_put_contents($file, $image_base64);

    //     return response()->json(['success'=>'success']);
    // }

    
}
