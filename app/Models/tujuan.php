<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tujuan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'tujuan';
    protected $filable = ['kode_tujuan','nama_tujuan'];

    public function indikator_tujuan()
    {
        return $this->hasMany(indikator_tujuan::class, 'tujuan_id', 'id');
    }
}
