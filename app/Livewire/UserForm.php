<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserForm extends Component
{
    public $userId;
    public $name = '';
    public $address = '';
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|min:3',
        'address' => 'required|min:3',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'name.min' => 'Nama minimal 3 karakter.',
        'address.required' => 'Alamat wajib diisi.',
        'address.min' => 'Alamat minimal 3 karakter.',
    ];

    public function mount($user = null)
    {
        if ($user) {
            $this->userId = $user;
            $this->isEdit = true;
            $userData = User::findOrFail($user);
            $this->name = $userData->name;
            $this->address = $userData->address;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            // Update user
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'address' => $this->address,
            ]);
            session()->flash('success', 'User berhasil diupdate.');
            $this->dispatch('userUpdated');
        } else {
            // Create new user
            User::create([
                'name' => $this->name,
                'address' => $this->address,
                'email' => fake()->unique()->safeEmail(), // Email dummy untuk demo
                'password' => bcrypt('password'), // Password dummy untuk demo
            ]);
            session()->flash('success', 'User berhasil ditambahkan.');
            $this->dispatch('userCreated');
        }

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.user-form')
            ->layout('components.layouts.user', ['title' => $this->isEdit ? 'Edit User' : 'Tambah User']);
    }
}
