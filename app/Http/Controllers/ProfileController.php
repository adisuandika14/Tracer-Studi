<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $profile = User::all();
        return view('/auth/admin/profile', compact('profile'));
    }

    public function update(Request $request){
        $profile = NULL;
        $profile = User::find($request->id);

        $file = $request->file('file');
		echo 'File Name: '.$file->getClientOriginalName();
		echo '<br>';
		echo 'File Extension: '.$file->getClientOriginalExtension();
		echo '<br>';
		echo 'File Real Path: '.$file->getRealPath();
		echo '<br>';
		echo 'File Size: '.$file->getSize();
		echo '<br>';
		echo 'File Mime Type: '.$file->getMimeType();
		$tujuan_upload = 'data_file';
		$file->move($tujuan_upload,$file->getClientOriginalName());
       return redirect('/admin/auth/profile')->with('success','Data berhasil diupdate!');

    }
}
