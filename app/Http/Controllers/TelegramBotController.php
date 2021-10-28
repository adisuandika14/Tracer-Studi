<?php

namespace App\Http\Controllers;

use App\tb_pengumuman;
use App\tb_lowongan;
use App\tb_alumni;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function updatedActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity);
    }

    public function storeMessage($id, Request $request){
        
        //$test = tb_pengumuman::all();
        //$alumni = tb_alumni::get('id_alumni', chunk_split(30) );
        $alumni = tb_alumni::get();
        $pengumuman=tb_pengumuman::find($id);

            foreach ($alumni as $alumni){
                // Telegram::sendMessage([
                //     'token' => env('TELEGRAM_BOT_TOKEN', ''),
                //     'parse_mode' => 'HTML',
                //     'chat_id' => $alumni->chat_id,
                //     'text' => $text
                // ]);
                $message = '--PENGUMUMAN--'
                            .'                                                                                      '.$pengumuman->judul
                            .'                                                                          Jenis Pengumuman: '.$pengumuman->jenis
                            .'                                                                          Perihal Pengumuman: '.$pengumuman->perihal
                           .'                                                                          Sifat Surat: '.$pengumuman->sifat_surat;
                             //.$pengumuman->lampiran
                             //.$pengumuman->InputFile::createFromContents(file_get_contents($lampiran->getRealPath()), Str::random(10) . '.' . $lampiran->getClientOriginalExtension());
                             
               $url = "https://api.telegram.org/bot1624417891:AAG3RpRFtFqGcRP1W6-TFDQtsOBYbf6i7BI/sendMessage?chat_id=".$alumni->chat_id."&text=".$message;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec ($ch);
                    $err = curl_error($ch);  //if you need
                    curl_close ($ch);
                    // return $response;
                
                if($pengumuman->lampiran != NULL){
                    $file_url = $pengumuman->lampiran;
                    $url = "https://api.telegram.org/bot1624417891:AAG3RpRFtFqGcRP1W6-TFDQtsOBYbf6i7BI/sendDocument?chat_id=".$alumni->chat_id."&document=".request()->getSchemeAndHttpHost()."".$file_url;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec ($ch);
                    $err = curl_error($ch);  //if you need
                    curl_close ($ch);
                }
            }

        
        
            // dd($text);
        return redirect()->back()->with('statusInput','Data berhasil dikirim!');
    }

    public function sendPhoto()
    {
        return view('photo');
    }

    public function storePhoto(Request $request)
    {
        $request->validate([
            'file' => 'file|mimes:jpeg,png,gif'
        ]);

        $photo = $request->file('file');

        Telegram::sendPhoto([
            'token' => env('TELEGRAM_BOT_TOKEN', ''),
            'photo' => InputFile::createFromContents(file_get_contents($photo->getRealPath()), Str::random(10) . '.' . $photo->getClientOriginalExtension())
        ]);

        return redirect()->back();
    }


    public function storelowongan($id, Request $request){
        
        //$test = tb_pengumuman::all();
        $alumni = tb_alumni::all();
        $lowongan=tb_lowongan::find($id);
        $text = $lowongan->jenis_pekerjaan;
            // "Pengumuman\n"
            // . "<b>judul Pengumuman: </b>\n"
            // . "$text->judul;\n"
            // . "<b>Message: </b>\n"
            // . $text->perihal;
            foreach ($alumni as $alumni){
                // Telegram::sendMessage([
                //     'token' => env('TELEGRAM_BOT_TOKEN', ''),
                //     'parse_mode' => 'HTML',
                //     'chat_id' => $alumni->chat_id,
                //     'text' => $text
                // ]);
                $message = '--WE ARE HIRING--'
                            .'                                                                          Jenis Pekerjaan: '.$lowongan->jenis_pekerjaan
                            .'                                                                          Nama perusahaan: '.$lowongan->nama_perusahaan;
                             //.$pengumuman->lampiran
                             //.$pengumuman->InputFile::createFromContents(file_get_contents($lampiran->getRealPath()), Str::random(10) . '.' . $lampiran->getClientOriginalExtension());
                             
               $url = "https://api.telegram.org/bot1624417891:AAGwDqAhk6CkTguTKt4jmxwABaYWVc4tDVE/sendMessage?chat_id=".$alumni->chat_id."&text=".$message;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec ($ch);
                    $err = curl_error($ch);  //if you need
                    curl_close ($ch);
                    // return $response;
                
                if($lowongan->lampiran != NULL){
                    $file_url = $lowongan->lampiran;
                    $url = "https://api.telegram.org/bot1624417891:AAGwDqAhk6CkTguTKt4jmxwABaYWVc4tDVE/sendDocument?chat_id=".$alumni->chat_id."&document=".request()->getSchemeAndHttpHost()."".$file_url;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec ($ch);
                    $err = curl_error($ch);  //if you need
                    curl_close ($ch);
                }
            }

        
        
            // dd($text);
        return redirect()->back()->with('statusInput','Data berhasil dikirim!');
    }
}