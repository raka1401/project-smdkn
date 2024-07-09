<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class indikator_tujuan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'indikator_tujuan';
    protected $filable = ['tujuan_id', 'nama_indikator', 'satuan', 't1', 't2', 't3', 't4', 't5'];


    public function tujuan()
    {
        return $this->belongsTo(tujuan::class, 'tujuan_id', 'id');
    }
}
