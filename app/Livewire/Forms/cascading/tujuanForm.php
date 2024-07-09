<?php

namespace App\Livewire\Forms\cascading;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Mary\Traits\Toast;
use App\Models\tujuan;

class tujuanForm extends Form
{
    public ?Tujuan $tujuan;
    #[Validate('required')]
    public $nama_tujuan;
    #[Validate('required')]
    public $kode_tujuan;

    use Toast;
    public bool $modalAdd = false;

    public function setTujuan(Tujuan $tujuan)
    {
        $this->tujuan = $tujuan;
        $this->kode_tujuan = $tujuan->kode_tujuan;
        $this->nama_tujuan = $tujuan->nama_tujuan;
    }


    public function store()
    {
        $this->validate();

        Tujuan::create([
            'kode_tujuan' => $this->kode_tujuan,
            'nama_tujuan' => $this->nama_tujuan,
        ]);
        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->tujuan->update([
            'kode_tujuan' => $this->kode_tujuan,
            'nama_tujuan' => $this->nama_tujuan,
        ]);
        $this->reset();
    }
}
