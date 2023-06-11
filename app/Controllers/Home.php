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
        ]);
        $users->save($user);

        $user = $users->findById($users->getInsertID())->addGroup('admin');
        dd($user);
        $users->addToDefaultGroup($user);

        return view('welcome_message');
    }
}
