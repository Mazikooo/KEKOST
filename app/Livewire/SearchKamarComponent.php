<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Kamar;

class SearchKamarComponent extends Component
{
    public $searchTerm = '';

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $kamars = Kamar::where('Nama_Kost', 'like', $searchTerm)
                        ->orWhere('Kota', 'like', $searchTerm)
                        ->orWhere('Harga', 'like', $searchTerm)
                        ->get();

        return view('livewire.search-kamar', ['kamars' => $kamars]);
    }
}
