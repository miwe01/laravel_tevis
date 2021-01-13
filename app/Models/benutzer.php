<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class benutzer extends Model
{
    public $timestamps = false;
    protected $table = 'benutzer';

    // letzten 5 Benutzer geordnet
    public function last5Users(){
        return $this
            ->select('Nachname', 'Vorname')
            ->orderBy('erfasst_am', 'desc')
            ->orderBy('Nachname', 'asc')
            ->take(5)
            ->get();
    }

    public function BenutzerAdd($request){
        $reqKennung = $request->kennung;
        $reqEmail = $request->email;
        $reqVorname = $request->vorname;
        $reqNachname = $request->nachname;
        $reqRolle = $request->rolle;
        $reqMatrikel = $request->matrikelnummer;

        $kennung = DB::table('benutzer')->where('Kennung', $reqKennung)->first();
        $email = DB::table('benutzer')->where('Email', $reqEmail)->first();

        // Email oder Kennung gibt es schon
        if ($kennung != NULL || $email != NULL){
            return 1;
        }

        // Hashing im Moment ist Standard Passwort 123456
        $passwort = Hash::make('123456');

        // insert Benutzer überprüft welche Rolle es ist
        DB::table('benutzer')->insert(
            ['Kennung'=>$reqKennung, 'Email'=>$reqEmail, 'Vorname'=>$reqVorname,
                'Nachname'=>$reqNachname, 'Password'=>$passwort
            ]
        );

        switch($reqRolle){
            case "student":
                DB::table('student')->insert(
                    ['Kennung'=>$reqKennung, 'Studiengang'=>'INF', 'Matrikelnummer'=>$reqMatrikel]
                );
                break;
            case "professor":
                DB::table('professor')->insert(
                    ['Kennung'=>$request->kennung, 'Titel'=>$request->titel]
                );
                break;
            case "wimi":
                DB::table('tutor')->insert(
                    ['Kennung'=>$request->kennung, 'Rolle'=>'WiMi']
                );
                break;
            case "hiwi":
                DB::table('tutor')->insert(
                    ['Kennung'=>$request->kennung, 'Rolle'=>'HiWi']
                );
                break;
            default:
                return 2;
        }

        return 0;
    }

    public function fileUpload($request){


    }




}
