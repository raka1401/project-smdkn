<?php

use Livewire\Volt\Volt;

Volt::route('/', 'users.index');
Volt::route('/tahun','master.tahun');

Volt::route('/tujuan','cascading.tujuan');
