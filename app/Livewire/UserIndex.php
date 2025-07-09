<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Logika bisnis: tidak boleh hapus user yang nama mengandung huruf "a" atau "A"
        if (stripos($user->name, 'a') !== false) {
            session()->flash('error', 'Tidak boleh menghapus user yang namanya mengandung huruf "a" atau "A".');
            $this->confirmingDelete = null;
            return;
        }

        $user->delete();
        session()->flash('success', 'User berhasil dihapus.');
        $this->confirmingDelete = null;
    }

    public function render()
    {
        // Mulai mengukur waktu
        $startTime = microtime(true);

        $users = User::select(['id', 'name', 'address', 'created_at']) // Pilih kolom yang diperlukan saja
            ->when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Hitung waktu eksekusi
        $queryTime = round((microtime(true) - $startTime) * 1000, 2); // dalam milliseconds

        return view('livewire.user-index', compact('users', 'queryTime'))
            ->layout('components.layouts.user', ['title' => 'Daftar User']);
    }
}

