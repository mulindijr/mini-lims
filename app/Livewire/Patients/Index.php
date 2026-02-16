<?php

namespace App\Livewire\Patients;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Patient;

class Index extends Component
{
    use WithPagination;

    public $showForm = false;
    public $editingPatientId = null;
    public $search = '';

    protected $listeners = ['patient-saved' => '$refresh'];

    public function handlePatientSaved()
    {
        $this->showForm = false;
        $this->editingPatientId = null;
        $this->resetPage(); // reset pagination
    }

    public function create()
    {
        $this->editingPatientId = null;
        $this->showForm = true;
    }

    public function edit($id)
    {
        $this->editingPatientId = $id;
        $this->showForm = true;
    }

    public function render()
    {
        $patients = Patient::query()
            ->where('first_name', 'like', "%{$this->search}%")
            ->orWhere('last_name', 'like', "%{$this->search}%")
            ->latest()
            ->paginate(10);

        return view('livewire.patients.index', compact('patients'));
    }
}