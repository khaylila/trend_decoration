<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;

class Home extends BaseController
{
    public function index()
    {
        // password google
        // frbfpeuczbjmcamt
        $users = auth()->getProvider();
        $user = new User([
            'username' => null,
            'email' => 'megaroy123@gmail.com',
            'password' => 'milea0201',
            'first_name' => 'Anas',
            'last_name' => 'Paiman',
            'phone_number' => '089670130349',
            'gender' => 'm',
            'birth_date' => "1965-05-12",
            'full_address' => 'Jalan Nanas 6a, Wage, Taman, Sidoarjo',
            'avatar' => 'logo.png',
        ]);
        $users->save($user);

        $users->findById($users->getInsertID())->addGroup('admin')->activate();

        return view('welcome_message');
    }
}
