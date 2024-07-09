<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tahun extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'tahun';
    protected $filable = ['nama_tahun', 'status'];
}
