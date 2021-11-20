<?php

namespace App\Http\Controllers;
use App\tb_pengumuman;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use AMBERSIVE\DocumentViewer\Abstracts\DocumentAbstract;
use App\Notifications\TelegramNotification;
use App\tb_detail_pengumuman;

class pengumumanController extends Controller
{

    public function show(){
        $pengumuman = tb_pengumuman::all();
        //dd($pengumuman);
        return view ('/pengumuman/pengumuman', compact('pengumuman'));
    }

    public function create(){
        $pengumuman = tb_pengumuman::where('deleted_at', NULL)->get();
        return view('/pengumuman/addpengumuman', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'max:512',
            'lampiran' => 'mimes:pdf|max:512',
        ],[
            'thumbnail.max' => "Ukuran File melebihi batas maksimum",
            'lampiran.mimes' => "Format file PDF",
            'lampiran.max' => "Ukuran File melebihi batas maksimum",
        ]);

        // $kategori = Kategori::find($request->kategori);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $arrImage = [];

        $post = new tb_pengumuman();
        $post->judul = $request->judul;
        $post->jenis = $request->jenis;
        $post->perihal = $request->perihal;
        $post->sifat_surat = $request->sifat_surat;
        
        //$post->tanggal_publish = $request->tanggal;

        if($request->file('lampiran')!=""){   
            $file = $request->file('lampiran');
            $fileLocation = '/file/posts/';
            $filename = rand().time().".".$file->getClientOriginalExtension();
            $path = $fileLocation."/".$filename;
            $post->lampiran = '/storage'.$path;
            $post->lampiran_name = $filename;
            Storage::disk('public')->put($path, file_get_contents($file));
        }

        if($request->file('thumbnail')!=""){
            $file = $request->file('thumbnail');
            $fileLocation = '/image/posts/';
            $filename = rand().time().".".$file->getClientOriginalExtension();
            $path = $fileLocation."/".$filename;
            $post->thumbnail = '/storage'.$path;
            $post->thumbnail_name = $filename;
            Storage::disk('public')->put($path, file_get_contents($file));
        }

        
        $detail = $request->judul;
        libxml_use_internal_errors(true);
        $dom = new \domdocument(); 
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $count => $image) {
            $src = $image->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimeType = $groups['mime'];
                $path = '/image/posts/'.$post->judul.'/content/'. uniqid('', true) . '.' . $mimeType;
                Storage::disk('public')->put($path, file_get_contents($src));
                $image->removeAttribute('src');
                $link = asset('storage'.$path);
                $image->setAttribute('src', $link);
                array_push($arrImage, $path);
            }
        }

        // Check file size
            // if ($_FILES["thumbnail"]["size"] > 500000) {
            // echo "Sorry, your file is too large.";
            // $uploadOk = 0;
            // }

            // // Allow certain file formats
            // if($file != "jpg" && $file != "png" && $file != "jpeg"
            // && $file != "gif" ) {
            // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            // $uploadOk = 0;
            // }


        $detail = $dom->savehtml();
        //$post->judul = $detail;
        $post->save();

        foreach($arrImage as $item){
            $postImage = new tb_detail_pengumuman();
            $postImage->id_post = $post->id;
            $postImage->image = $item;
            $postImage->save();
        }


    
        //return  $post;


        return redirect('/admin/pengumuman')->with('sukses', 'Data berhasil ditambahkan');
    }


    public function delete($id) 
    {
    	$post = tb_pengumuman::find($id);
        $post->delete();
        return redirect('/admin/pengumuman')->with('sukses', 'Data berhasil dihapus');
    }



    public function detail($id)
    {
        $post = tb_pengumuman::where('id_pengumuman', $id)->first();
        //dd($post);
        return view('/pengumuman/showpengumuman', compact('post'));
    }


    public function edit($id){
        $post = tb_pengumuman::find($id);
        return view('/pengumuman/editpengumuman', compact('post'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'max:512',
            'lampiran' => 'mimes:pdf|max:512',
        ],[
            'thumbnail.max' => "Ukuran File melebihi batas maksimum",
            'lampiran.mimes' => "Format file PDF",
            'lampiran.max' => "Ukuran File melebihi batas maksimum",
        ]);

        
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        
        $post = tb_pengumuman::find($id);
        $arrImage = [];
        $idImage = [];

        $post->judul = $request->judul;
        //$post->title_slug = Str::slug($request->title_ina);
        //$post->status = 'aktif';
        //$post->tgl_post = $request->tgl_post;
        $post->jenis = $request->jenis;
        $post->sifat_surat = $request->sifat_surat;
        $post->perihal = $request->perihal;


        if($request->file('lampiran')!=""){
            Storage::disk('public')->delete($post->lampiran);
            $file = $request->file('lampiran');
            $fileLocation = '/file/posts/';
            $filename = rand(). time();
            $path = $fileLocation."/".$filename;
            $post->lampiran = '/storage'.$path;
            $post->lampiran_name = $filename;
            Storage::disk('public')->put($path, file_get_contents($file));
        }

        if($request->file('thumbnail')!=""){
            Storage::disk('public')->delete($post->thumbnail);
            $file = $request->file('thumbnail');
            $fileLocation = '/image/posts/';
            $filename = $file->getClientOriginalName();
            $path = $fileLocation."/".$filename;
            $post->thumbnail = '/storage'.$path;
            $post->thumbnail_name = $filename;
            Storage::disk('public')->put($path, file_get_contents($file));
        }

        
        $detail = $request->jenis;
        libxml_use_internal_errors(true);
        $dom = new \domdocument();
        //$dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        $postImage = tb_pengumuman::where('id_pengumuman','=', $id)->get();

        //variabel dummy
                $arrsrc = [];
                $arrfoto = [];
                $status = '';
        //variabel dummy

        foreach ($images as $count => $image) {
            $src = $image->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimeType = $groups['mime'];
                $path = '/image/posts/'.$post->pengumuman_lower.'/'.$post->judul.'/content/'. uniqid('', true) . '.' . $mimeType;
                Storage::disk('public')->put($path, file_get_contents($src));
                $image->removeAttribute('src');
                $link = asset('storage'.$path);
                $image->setAttribute('src', $link);
                array_push($arrImage, $path);
            }
            if($postImage != null){
                foreach($postImage as $item){
                    $src = str_replace('/',' ',$src);
                    $item->image = str_replace(' ','%20',$item->image);
                    $item->image = str_replace('/', ' ',$item->image);
                    array_push($arrsrc, $src);
                    array_push($arrfoto, $item->image);
                    if(preg_match('/'.$item->image.'/',$src)){
                        array_push($arrsrc, 'true');
                        array_push($idImage, $item->id);
                    break;
                    }
                }   
            }
        }

        // $postImages = PostImage::whereNotIn('id', $idImage)->where('id_post',$id)->get();
        // PostImage::whereNotIn('id', $idImage)->where('id_post',$id)->delete();
        // foreach($postImages as $item){
        //     Storage::disk('public')->delete($item->image);
        // }

        $detail = $dom->savehtml();
        //$post->jenis = $detail;
        $post->update();

        // foreach($arrImage as $item){
        //     $pageImage = new PostImage();
        //     $pageImage->id_post = $post->id;
        //     $pageImage->image = $item;
        //     $pageImage->save();
        // }

        return redirect('/admin/pengumuman')->with('sukses', 'Data Berhasil diperbaharui!');
    }



    public function TelegrmNotif(array $data){

        $user = tb_pengumuman::create([
            'judul' => $data['judul'],
        ]);

        $user->notify(new TelegramNotification([
            'text' => "Welcome to the application " . $user->judul . "!"
        ]));
    
        return  $user;
    }



}
