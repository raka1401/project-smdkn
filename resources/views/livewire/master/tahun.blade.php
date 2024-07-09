<?php

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Livewire\Forms\master\tahunForm;
use App\Models\Tahun;
use Mary\Traits\Toast;

new class extends Component {
    public TahunForm $form;
    use Toast;
    use withPagination;

    #[Rule('required')]
    public string $nama_tahun = '';
    #[Rule('required')]
    public string $status = '';

    public $tahunid;
    public $title = 'Tahun';
    public string $search = '';
    public array $sortBy = ['column' => 'nama_tahun', 'direction' => 'asc'];

    public bool $modalAdd = false;
    public bool $editMode = false;
    public bool $modalDelete = false;

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'tahun' => $this->tahun(),
        ];
    }

    public function headers(): array
    {
        return [
            ['key' => 'nama_tahun', 'label' => 'Tahun', 'class' => 'w-50 text-center'], 
            ['key' => 'status', 'label' => 'Status', 'class' => 'w-30 text-center']];
    }

    public function showModal()
    {
        $this->editMode = false;
        $this->form->reset();
        $this->title = 'Tambah Data Tahun';
        $this->modalAdd = true;
    }

    public function save(): void
    {
        if ($this->editMode) {
            $this->form->update();
            $this->success('Data tahun berhasil diubah.');
        } else {
            $this->form->store();
            $this->success('Data tahun berhasil ditambahkan.');
        }
        $this->modalAdd = false;
    }

    public function edit($id)
    {
        $this->title = 'Edit Data Tahun';
        $data = Tahun::find($id);
        $this->form->setTahun($data);
        $this->editMode = true;
        $this->modalAdd = true;
    }

    public function clear()
    {
        $this->title = '';
        $this->nama_tahun = '';
        $this->status = '';
    }

    public function tahun(): LengthAwarePaginator
    {
        return Tahun::query()
            ->when($this->search, fn(Builder $q) => $q->where('nama_tahun', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5);
    }

    public function delete($tahunid)
    {
        $this->tahunid = $tahunid;
        $this->modalDelete = true;
    }
    
    public function hapus()
    {
        Tahun::find($this->tahunid)->delete();
        $this->modalDelete = false;
        $this->warning('Data Berhasi dihapus', 'Good bye!', position: 'toast-bottom');
    }
}; ?>

<div>
    
    <x-header title="Data Tahun" separator progres-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live="search"  debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button class="btn-primary btn-circle" @click="$wire.showModal()" icon="o-plus" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <x-table with-pagination :rows="$tahun" :sort-by="$sortBy" @row-click="$wire.edit($event.detail.id)"
                    :headers="$headers">
                    @scope('cell_status', $tahun)
                        @if ($tahun->status == 1)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-error">Tidak Aktif</span>
                        @endif
                    @endscope
                    @scope('actions', $tahun)
                        <x-button spinner icon="o-trash" wire:click="delete({{ $tahun['id'] }})" 
                             @click="event.stopPropagation()"
                             class="btn-ghost btn-sm text-red-500" />
                    @endscope
                </x-table>
            </div>
            <div>
                <img src="/tambah-data.png" width="300" class="mx-auto" />
            </div>
        </div>

    </x-card>

    <x-modal wire:model='modalAdd' :title="$title">
        <div class="grid gap-5">
            <div>
                <x-form wire:submit='save'>
                    <x-input placeholder="Tahun" wire:model='form.nama_tahun' type="number" />
                    <select class="select select-bordered w-full" wire:model='form.status'>
                        <option value="0">Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <x-slot:actions>
                        <x-button label="Simpan" spinner="save" type="submit" class="btn-primary"
                            icon="o-cloud-arrow-up" />
                        <x-button label="Batal" @click="$wire.modalAdd = false" />
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
