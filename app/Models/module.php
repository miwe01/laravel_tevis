<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class module extends Model
{
    public $timestamps = false;
    protected $table = 'modul';

    public function getWintermodule(){
        return $this->select('Modulnummer', 'Modulname', 'Semester', 'Jahr')
            ->where('Semester', 'WiSe')
            ->get();
    }
    public function getSommerModule(){
        return $this->select('Modulnummer', 'Modulname', 'Semester', 'Jahr')
            ->where('Semester', 'SoSe')
            ->get();
    }


}
