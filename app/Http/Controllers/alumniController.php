<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Exports\AlumniExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\tb_alumni;
use App\tb_angkatan;
use App\tb_prodi;
use App\tb_notifikasi;
use App\tb_jawaban;
use App\tb_soal_alumni;
use App\tb_periode;
use App\tb_tahun_periode;
use App\Imports\AlumniImport;
use App\Http\Controllers\Controller;
use App\tb_periodealumni;
use PhpOffice\PhpSpreadsheet\Shared\Date;


use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class alumniController extends Controller
{

    public function periode(){
        $periodealumni = tb_periodealumni::get();
        $tahun = tb_tahun_periode::get();
        $periode = tb_periode::get();

        return view ('/alumni/periodealumni',compact('periodealumni','tahun','periode'));
    }

    public function createperiode(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'id_tahun_periode' => 'required|unique:tb_periodealumni,id_tahun_periode',
        //     'id_periode' => 'required|unique:tb_periodealumni,id_periode',
        // ],[
        //      'id_tahun_periode.required' => "Anda Belum Menambahkan Tahun Periode",
        //      'id_periode.unique' => "Tahun yang dimasukkan sudah Terdaftar",
        //  ]);

        // if($validator->fails()){
        //     return back()->withErrors($validator);
        // }
        $periodealumni = new tb_periodealumni;
        $periodealumni->id_tahun_periode = $request->id_tahun_periode;
        $periodealumni->id_periode = $request->id_periode;
        $periodealumni->save();

        return redirect('/admin/periodealumni')->with('sukses','Data Berhasil ditambahkan');
    }

    public function updateperiode(Request $request){
        $updateperiode = tb_periodealumni::find($request->id_periode_alumni);
        $updateperiode->id_tahun_periode = $request->id_tahun_periode;
        $updateperiode->id_periode = $request->id_periode;
        $updateperiode->update();

        return redirect ('/admin/periodealumni')->with('sukses','Data Berhasil Diperbaharui');
    }

    public function deleteperiode($id, Request $request)
    {

        $deleteperiode = tb_periodealumni::where('id_periode_alumni', $id);
        $deleteperiode->delete();
        return back()->with('sukses','Data berhasil dihapus');
    }


    public function show($id){
        $periodes = tb_periodealumni::where('id_periode_alumni', $id)->first();
        $tahun_lulus = tb_tahun_periode::where('id_tahun_periode', $periodes->id_tahun_periode)->first()->tahun_periode;
        $periodealumni = tb_periode::where('id_periode', $periodes->id_periode)->first()->periode;

        $periode = tb_periodealumni::find($id);
        $alumni = tb_alumni::where('id_periode',$id)->with('relasiAlumnitoAngkatan','relasiAlumnitoProdi')->get();
        $id_periode = $id;
        $prodi = tb_prodi::get();
        $angkatan = tb_angkatan::orderBy('tahun_angkatan','asc')->get();
        $id_periode_alumni = $id;
        $status = ['Tolak','Konfirmasi','Menunggu Konfirmasi'];

        return view('/alumni/dataalumni', compact ('id_periode_alumni','alumni','prodi','angkatan','tahun_lulus','periodealumni'), ['alumni'=>$alumni]);
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_alumni' => 'required|unique',
            'nik' => 'required',
            'jenis_kelamin' => 'required',
            'alamat_alumni' => 'required',
            'id_prodi' => 'required',
            'id_angkatan' => 'required',
        ],[
             'nama_alumni.required' => "Nama wajib diisi",
             'nik.required' => "Nik wajib diisi",
             'jenis_kelamin.required' => "Jenis Kelamin wajib diisi",
             'alamat_alumni.required' => "Alamat wajib diisi",
             'id_prodi.required' => "Program Studi wajib diisi",
             'id_angkatan.required' => "Angkatan wajib diisi",
         ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $createalumni = new tb_alumni();
        $createalumni->id_periode = $request->id_periode;
        $createalumni->nama_alumni = $request->nama_alumni;
        $createalumni->nik = $request->nik;
        $createalumni->nim_alumni = $request->nim_alumni;
        $createalumni->jenis_kelamin = $request->jenis_kelamin;
        $createalumni->alamat_alumni = $request->alamat_alumni;
        $createalumni->id_prodi = $request->id_prodi;
        $createalumni->id_angkatan = $request->id_angkatan;
        $createalumni->email = $request->email;
        $createalumni->no_hp = $request->no_hp;
        $createalumni->id_line = $request->id_line;
        $createalumni->id_telegram = $request->id_telegram;
        $createalumni->tahun_lulus = $request->tahun_lulus;
        $createalumni->tahun_wisuda = $request->tahun_wisuda;
        $createalumni->status = "Menunggu Konfirmasi";
        $createalumni->save();

        return redirect('/admin/alumni/'.$request->id_periode)->with('sukses','Data berhasil disimpan!');

    }

    public function delete($id, Request $request){
        
        $deletedata = tb_alumni::where('id_alumni', $id);
        $deletedata->id_periode = $request->id_periode;
        return back()->with('sukses','Data berhasil dihapus!');
    }

    
    public function update(Request $request){
        $res = NULL;
        $updatedata = tb_alumni::find($request->id_alumni);
        $updatedata->id_periode = $request->id_periode;
        $updatedata->nama_alumni = $request->nama_alumni;
        $updatedata->nik = $request->nik;
        $updatedata->nim_alumni = $request->nim_alumni;
        $updatedata->jenis_kelamin = $request->jenis_kelamin;
        $updatedata->alamat_alumni = $request->alamat_alumni;
        $updatedata->id_prodi = $request->id_prodi;
        $updatedata->id_angkatan = $request->id_angkatan;
        $updatedata->email = $request->email;
        $updatedata->no_hp = $request->no_hp;
        $updatedata->id_line = $request->id_line;
        $updatedata->id_telegram = $request->id_telegram;
        $updatedata->tahun_lulus = $request->tahun_lulus;
        $updatedata->tahun_wisuda = $request->tahun_wisuda;
        $updatedata->status = $request->status;
        $updatedata->update();
        //dd($updatedata);
       return redirect('/admin/alumni/'.$request->id_periode)->with('sukses','Data berhasil diupdate!');
    }


    // public function export_mapping() {
    //     return Excel::download( new AlumniExport(), 'Data Tracer Lulusan Alumni Dakulltas Teknik.xlsx') ;
    // }

    public function export(){
        return Excel::download(new ALumniExport, 'Data Alumni.xlsx');
    }


    public function import_excel(Request $request) 
	{
        $res = NULL;

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

                $alumni = New tb_alumni();
                $alumni->id_periode = $request->id_periode;
                $alumni->nama_alumni = $rows[$count][$hitung]['nama_alumni'];
                $alumni->nik = $rows[$count][$hitung]['nik'];
                $alumni->jenis_kelamin = $rows[$count][$hitung]['jenis_kelamin'];
                $alumni->nim_alumni = $rows[$count][$hitung]['nim_alumni'];
                $alumni->id_angkatan = $id_angkatan;
                $alumni->id_prodi = $id_prodi;
                $alumni->alamat_alumni = $rows[$count][$hitung]['alamat_alumni'];
                $alumni->password = Hash::make($rows[$count][$hitung]['nim_alumni']);
                $alumni->tahun_lulus = Date::excelToDateTimeObject($rows[$count][$hitung]['tahun_lulus'])->format('Y-m-d');
                $alumni->tahun_wisuda = Date::excelToDateTimeObject($rows[$count][$hitung]['tahun_wisuda'])->format('Y-m-d');
                $alumni->no_hp = $rows[$count][$hitung]['no_hp'];
                $alumni->email = $rows[$count][$hitung]['email'];
                $alumni->id_telegram = $rows[$count][$hitung]['id_telegram'];
                $alumni->id_line = $rows[$count][$hitung]['id_line'];
                $alumni->status = "Konfirmasi";
                $alumni->save();
            }
        }
	    return redirect('/admin/alumni/'.$request->id_periode)->with('sukses','Data berhasil ditambahkan!');
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
            $status->id_periode = $request->id_periode;
            $status->id_alumni = $request->id_alumni;
            $status->notifikasi = $request->notifikasi;
            $status->notifikasi_unique = Str::random(32);
            $status->flag = '0';
            $status->save();
        }
        return redirect('/admin/alumni/'.$request->id_periode)->with('sukses','Data berhasil diperbaharui!');
    }

    public function bacaNotif($notifikasi_unique)
    {
        $id = tb_notifikasi::where('notifikasi_unique', $notifikasi_unique)->first();
        $notif = $id->id_notifikasi;
        $notif = tb_notifikasi::find($notif);
        $notif->flag = '1';
        $notif->save();

        return redirect()->back();
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

        public function filtertracer(Request $request){
        if($request->prodi == "" && $request->angkatan == ""){
            return redirect ('/kuesioner/tracer');
        }else if($request->prodi == "" && $request->angkatan != ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_angkatan', $request->angkatan)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_angkatan = $request->angkatan;
            return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan', 'id_angkatan'));
        }else if($request->prodi != "" && $request->angkatan == ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_prodi = $request->prodi;
            return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan', 'id_prodi'));
        }else if($request->prodi != "" && $request->angkatan != ""){
            $all_jawaban = tb_jawaban::get(['id_alumni'])->toArray();
            $tracers = tb_alumni::with('relasiAlumnitoProdi')->whereIn('id_alumni', $all_jawaban)->where('id_prodi', $request->prodi)->where('id_angkatan', $request->angkatan)->get();
            $prodi = tb_prodi::get();
            $angkatan = tb_angkatan::get();
            $id_angkatan = $request->angkatan;
            $id_prodi = $request->prodi;
            return view ('/kuesioner/tracer', compact('tracers', 'prodi', 'angkatan', 'id_prodi', 'id_angkatan'));
        }
    }

    public function detailtracer($id){
        $alumni = tb_alumni::where('id_alumni', $id)->first();
        $jawaban = tb_jawaban::with('relasiJawabantoDetail')->where('id_alumni', $alumni->id_alumni)->get();

        //dd($detailjawaban);
        return view ('/kuesioner/detailtracer', compact('alumni', 'jawaban'));
    }
}
