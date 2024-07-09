<?php

namespace App\Livewire\Forms\master;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Mary\Traits\Toast;
use App\Models\tahun;

class tahunForm extends Form
{
    public ?Tahun $tahun;
    #[Validate('required')]
    public $nama_tahun;
    #[Validate('required')]
    public $status;

    use Toast;
    public bool $modalAdd = false;

    public function setTahun(Tahun $tahun)
    {
        $this->tahun = $tahun;
        $this->nama_tahun = $tahun->nama_tahun;
        $this->status = $tahun->status;
    }


    public function store()
    {
        $this->validate();

        Tahun::create([
            'nama_tahun' => $this->nama_tahun,
            'status' => $this->status,
        ]);
        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->tahun->update([
            'nama_tahun' => $this->nama_tahun,
            'status' => $this->status,
        ]);
        $this->reset();
    }
}
