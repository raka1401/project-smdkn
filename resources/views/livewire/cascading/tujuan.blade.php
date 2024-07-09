<?php

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;
use App\Livewire\Forms\cascading\tujuanForm;
use App\Models\Tujuan;
use App\Models\Indikator_tujuan;

new class extends Component {
    public tujuanForm $form;
    use Toast;
    use withPagination;
    public array $expanded = [];


    #[Rule('required')]
    public string $nama_tujuan = '';
    #[Rule('required')]
    public string $kode_tujuan = '';

    public $tujuanId;
    public $title = '';
    public string $search = '';
    public array $sortBy = ['column' => 'tujuan', 'direction' => 'asc'];

    public bool $modalForm = false;
    public bool $editMode = false;
    public bool $modalDelete = false;

    public function with(): array
    {
        return [
            'tabelTujuan' => $this->tabelTujuan(),
            'tujuan' => $this->tujuan(),
        ];
    }

    public function tabelTujuan(): array
    {
        return [
            ['key' => 'kode_tujuan', 'label' => 'Kode', 'class' => 'w-20 text-center'], 
            ['key' => 'nama_tujuan', 'label' => 'Tujuan', 'class' => 'w-60 text-center']];
    }

    public function showModal()
    {
        $this->editMode = false;
        $this->form->reset();
        $this->title = 'Tambah Data Tujuan';
        $this->modalForm = true;
    }

    public function save(): void
    {
        if ($this->editMode) {
            $this->form->update();
            $this->success('Data tujuan berhasil diubah.');
        } else {
            $this->form->store();
            $this->success('Data tujuan berhasil ditambahkan.');
        }
        $this->modalForm = false;
    }

    public function edit($id)
    {
        $this->title = 'Edit Data Tujuan';
        $data = Tujuan::find($id);
        $this->form->setTujuan($data);
        $this->editMode = true;
        $this->modalForm = true;
    }

    public function clear()
    {
        $this->title = '';
        $this->kode_tujuan = '';
        $this->nama_tujuan = '';
    }

    public function tujuan(): LengthAwarePaginator
    {
        return Tujuan::query()
            ->when($this->search, fn(Builder $q) => $q->where('nama_tujuan', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5);
    }

    public function indikator_tujuan()
    {
        return Indikator_tujuan::get();
    }

    public function delete($tujuanId)
    {
        $this->tujuanId = $tujuanId;
        $this->modalDelete = true;
    }
    
    public function hapus()
    {
        Tujuan::find($this->tujuanId)->delete();
        $this->modalDelete = false;
        $this->warning('Data Berhasi dihapus', 'Good bye!', position: 'toast-bottom');
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Cascading Tujuan" separator progres-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live="search" debounce="search" clearable
                icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button class="btn-primary btn-circle" @click="$wire.showModal()" icon="o-plus" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <div class="overflow-x-auto">
            
            <x-table with-pagination :rows="$tujuan" :sort-by="$sortBy" @row-click="$wire.edit($event.detail.id)"
            :headers="$tabelTujuan" wire:model="expanded" expandable>
            @scope('expansion', $tujuan)
             <livewire:cascading.indikator_tujuan :tujuan="$tujuan"/>
            @endscope
            @scope('actions', $tujuan)
                <x-button spinner icon="o-trash" wire:click="delete({{ $tujuan['id'] }})" 
                     @click="event.stopPropagation()"
                     class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
        </div>
    </x-card>

    <x-modal wire:model='modalForm' :title="$title">
        <div class="grid gap-5">
            <div>
                <x-form wire:submit='save'>
                    <x-input placeholder="Kode Tujuan" wire:model='form.kode_tujuan' type="text" />
                    <x-input placeholder="Tujuan" wire:model='form.nama_tujuan' type="text" />
                    <x-slot:actions>
                        <x-button label="Simpan" spinner="save" type="submit" class="btn-primary"
                            icon="o-cloud-arrow-up" />
                        <x-button label="Batal" @click="$wire.modalForm = false" />
                    </x-slot:actions>
                </x-form>
            </div>
        </div>
    </x-modal>

    <x-modal wire:model='modalDelete' title="">
        <div>
            <img src="/warning.png" width="200" class="mx-auto gap-1" />
            <div class="text-center text-2xl text-error">
                Apakah anda yakin ingin menghapus data ini?
            </div>
        </div>
        <div class="text-center">Data yang di hapus tidak dapat dikembalikan !!!</div>

        <x-slot:actions>
            <x-button label="Batal" @click="$wire.modalDelete = false" />
            <x-button label="Ya Hapus" class="btn-error" wire:click='hapus' />
        </x-slot:actions>
    </x-modal>
</div>
