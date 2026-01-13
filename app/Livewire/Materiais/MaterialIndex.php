<?php

namespace App\Livewire\Materiais;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Material;
use Livewire\WithPagination;

class MaterialIndex extends Component
{
    use WithPagination;
        #[Layout('layouts.app')]

    public function delete($id)
    {
        Material::find($id)->delete();
        session()->flash('message', 'Material excluído.');
    }

    public function render()
    {
        $materiais = Material::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.materiais.material-index', ['materiais' => $materiais]);
    }
}