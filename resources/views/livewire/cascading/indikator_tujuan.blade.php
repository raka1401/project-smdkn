<?php

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator; 
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use App\Models\Tujuan;
use App\Models\Indikator_tujuan;

new class extends Component {

    public $tujuan;
    public $title= '';

    public bool $modalForm = false;
    
    public function showModal()
    {
        // $this->editMode = false;
        // $this->form->reset();
        $this->title = 'Tambah Indikator Tujuan';
        $this->modalForm = true;
    }

}; ?>

<div>
    <div class="overflow-x-auto">
        <div class="flex justify-end">
            <x-button class="btn-primary btn-sm" label="Tambah Indikator" icon="o-plus" @click="$wire.showModal()" />
        </div>
        <table class="table">
          <!-- head -->
          <thead>
            <tr>
              <th rowspan="2">Indikator</th>
              <th rowspan="2">Satuan</th>
              <th colspan="5" class="text-center">Target</th>
              <th rowspan="2"></th>
            </tr>
            <tr>
                <th>n-1</th>
                <th>n-2</th>
                <th>n-3</th>
                <th>n-4</th>
                <th>n-5</th>
            </tr>
          </thead>
          <tbody>
            <!-- row 2 -->
            @foreach ($tujuan->indikator_tujuan as $item)
            <tr class="hover" wire:click="edit({{ $item->id }})">
                <td>{{ $item->nama_indikator }}</td>
                <td>{{ $item->satuan }}</td>
                <td>{{ $item->t1 }}</td>
                <td>{{ $item->t2 }}</td>
                <td>{{ $item->t3 }}</td>
                <td>{{ $item->t4 }}</td>
                <td>{{ $item->t5 }}</td>
                <td>
                    <x-button spinner icon="o-trash" wire:click="delete({{ $tujuan['id'] }})" 
                    @click="event.stopPropagation()"
                    class="btn-ghost btn-sm text-red-500" />
                </td>
            @endforeach
            </tr>
          </tbody>
        </table>
      </div>

      <x-modal wire:model='modalForm' :title="$title" class="w">
        <div class="grid gap-5">
            <div>
                <x-form wire:submit='save'>
                    <x-input value="{{ $tujuan->nama_tujuan }}" readonly />
                    <x-input placeholder="Indikator Tujuan" wire:model='form.kode_tujuan' type="text" />
                    <x-input placeholder="Satuan" wire:model='form.nama_tujuan' type="text" />
                    <x-input type="text" placeholder="Target 1" wire:model="form.t1" />
                    <x-input type="text" placeholder="Target 2" wire:model="form.t2" />
                    <x-input type="text" placeholder="Target 3" wire:model="form.t3" />
                    <x-input type="text" placeholder="Target 4" wire:model="form.t4" />
                    <x-input type="text" placeholder="Target 5" wire:model="form.t5" />
                    <x-slot:actions>
                        <x-button label="Simpan" spinner="save" type="submit" class="btn-primary"
                            icon="o-cloud-arrow-up" />
                        <x-button label="Batal" @click="$wire.modalForm = false" />
                    </x-slot:actions>
                </x-form>
            </div>
        </div>
    </x-modal>
</div>
