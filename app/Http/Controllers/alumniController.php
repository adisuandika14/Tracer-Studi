<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exports\AlumniExport;
use Maatwebsite\Excel\Facades\Excel;
use App\tb_alumni;
use App\tb_angkatan;
use App\tb_kota;
use App\tb_provinsi;
use App\tb_prodi;
use App\tb_gender;
use App\tb_notifikasi;
use App\tb_jawaban;
use App\tb_soal_alumni;
use App\tb_periode;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Session;
use App\Imports\AlumniImport;
use App\Http\Controllers\Controller;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class alumniController extends Controller
{

    public function show(){

    $alumni = tb_alumni::with('relasiAlumnitoAngkatan','relasiAlumnitoProdi','relasiAlumnitoGender')->get();
    //$alumni = tb_alumni::all();
    $prodi = tb_prodi::get();
    //$gender = tb_gender::get();
    $angkatan = tb_angkatan::get();
    //$kota = tb_kota::get();
    //$provinsi = tb_provinsi::get();
    $status = ['Tolak','Konfirmasi','Menunggu Konfirmasi'];

    $province = Province::get();
    $regencies = Regency::get();
    $districts = District::get();
    $villages = Village::get();

        return view('/alumni/dataalumni', compact ('alumni','prodi','angkatan','province','regencies','districts','villages'), ['alumni'=>$alumni]);
    }

    // public function getMenu($id){
    //     $menus = Menu::where('id_header', $id)->get();
    //     return response()->json(
    //         $menus
    //     );
    // }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_alumni' => 'required',
            'jenis_kelamin' => 'required',
            'alamat_alumni' => 'required',
            'id_prodi' => 'required',
            'id-angkatan' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'id_line' => 'required',
            'id_telegram' => 'required',
            'tahun_lulus' => 'required',
            'tahun_wisuda' => 'required',
        ],[
             'nama_alumni.required' => "Nama wajib diisi",
             'username.required' => "Username wajib diisi",
             'username.unique' => "Username telah terdaftar",
         ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

            tb_alumni::create([
                'nama_alumni'=>$request->nama_alumni,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'alamat_alumni'=>$request->alamat_alumni,
                'id_prodi'=>$request->id_prodi,
                'id_angkatan'=>$request->id_angkatan,
                'email'=>$request->email,
                'no_hp'=>$request->no_hp,
                'id_line'=>$request->id_line,
                'id_telegram'=>$request->id_telegram,
                'tahun_lulus'=>$request->tahun_lulus,
                'tahun_wisuda'=>$request->tahun_wisuda,
                'status' =>$request->status = "Menunggu Konfirmasi",
                ]);
            return redirect('/admin/alumni')->with('sukses','Data berhasil disimpan!');

    }

    public function delete($id){
        $deletedata = tb_alumni::where('id_alumni', $id);
        $deletedata->delete();
        return redirect('/admin/alumni')->with('sukses','Data berhasil dihapus!');
    }

    // public function edit(tb_alumni $id_alumni)
    // {
    //     $editdata = tb_alumni::find($id_alumni);
    //     return response()->json(['sukses' => 'Berhasil', 'alumni' => $editdata]);
    // }

    
    public function update(Request $request){
        $res = NULL;
        $updatedata = tb_alumni::find($request->id_alumni);
        $updatedata->nama_alumni = $request->nama_alumni;
        $updatedata->nik = $request->nik;
        $updatedata->jenis_kelamin = $request->jenis_kelamin;
        $updatedata->id_prodi = $request->id_prodi;
        $updatedata->id_angkatan = $request->id_angkatan;
        $updatedata->alamat_alumni = $request->alamat_alumni;
        $updatedata->email = $request->email;
        $updatedata->no_hp = $request->no_hp;
        $updatedata->id_line = $request->id_line;
        $updatedata->id_telegram = $request->id_telegram;
        $updatedata->tahun_lulus = $request->tahun_lulus;
        $updatedata->tahun_wisuda = $request->tahun_wisuda;
        $updatedata->status = $request->status;
        $updatedata->update();
        //dd($updatedata);
       return redirect('/admin/alumni')->with('sukses','Data berhasil diupdate!');
    }


    public function export_mapping() {
        return Excel::download( new AlumniExport(), 'Data Tracer Lulusan Alumni Dakulltas Teknik.xlsx') ;
    }

    // public function export(){
    //     return Excel::download(new ALumniExport, 'Data Alumni.xlsx');
    // }


    public function import_excel(Request $request) 
	{
        $file = $request->file('file');
        $rows = Excel::ToCollection(new AlumniImport, $file);
        $prodis = tb_prodi::get();
        $angkatans = tb_angkatan::get();
        

        $id_prodi = 0;
        $id_angkatan = 0;
        $counts = count($rows);
        for ($count = 0; $count < $counts; $count++){
            $hitungs = count($rows[$count]);
            for ($hitung = 0; $hitung < $hitungs; $hitung++){
                
                foreach($prodis as $prodi){
                    if($prodi->nama_prodi == $rows[$count][$hitung]['nama_prodi']){
                        $id_prodi = $prodi->id_prodi;
                    }
                }

                foreach($angkatans as $angkatan){
                    if($angkatan->tahun_angkatan == $rows[$count][$hitung]['tahun_angkatan']){
                        $id_angkatan = $angkatan->id_angkatan;
                    }
                }

                $alumni = New tb_angkatan();
                $alumni->tahun_angkatan = $rows[$count][$hitung]['tahun_angkatan']; 

                $alumni = New tb_alumni();
                $alumni->nama_alumni = $rows[$count][$hitung]['nama_alumni'];
                $alumni->nik = $rows[$count][$hitung]['nik'];
                $alumni->jenis_kelamin = $rows[$count][$hitung]['jenis_kelamin'];
                $alumni->nim_alumni = $rows[$count][$hitung]['nim_alumni'];
                $alumni->id_angkatan = $id_angkatan;
                $alumni->id_prodi = $id_prodi;
                $alumni->alamat_alumni = $rows[$count][$hitung]['alamat_alumni'];
                $alumni->tahun_lulus = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[$count][$hitung]['tahun_lulus'])->format('Y-m-d');
                $alumni->tahun_wisuda = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[$count][$hitung]['tahun_wisuda'])->format('Y-m-d');
                $alumni->no_hp = $rows[$count][$hitung]['no_hp'];
                $alumni->email = $rows[$count][$hitung]['email'];
                $alumni->id_telegram = $rows[$count][$hitung]['id_telegram'];
                $alumni->id_line = $rows[$count][$hitung]['id_line'];
                $alumni->status = "Menunggu Konfirmasi";
                $alumni->save();
            }
        }
	    return redirect('/admin/alumni')->with('statusInput', 'Data Berhasil Diimport');
	}

    public function status(Request $request)
    {
        $res = NULL;
            $updatestatus = tb_alumni::find($request->id_alumni);
            $updatestatus->status = $request->status;
            $updatestatus->update();
        
        if($request->status == "Konfirmasi"){
            $status = new tb_notifikasi();
            $status->id_alumni = $request->id_alumni;
            $status->notifikasi = 'Data Yang anda masukkan sudah Terverifikasi';
            $status->flag = '0';
            $status->save();
        }
        elseif($request->status == "Ditolak"){
            $status = new tb_notifikasi();
            $status->id_alumni = $request->id_alumni;
            $status->notifikasi = $request->notifikasi;
            $status->notifikasi_unique = Str::random(32);
            $status->flag = '0';
            $status->save();
        }
        return  redirect('/admin/alumni')->with('statusInput','Data berhasil diupdate!');
    }

    public function bacaNotif($id)
    {
        $notif = tb_notifikasi::find($id);
        $notif->flag = '1';
        $notif->save();

        return redirect('/admin/alumni');
    }

    public function tracer(){
        $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
        $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->get();
        $kategori_1 = tb_soal_alumni::all();
        // $kategori_2 = tb_soal_alumni::all();
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::get();
        $periode = tb_periode::get();
        return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan','periode', 'kategori_1'));
    }


}
