<?php

namespace App\Controllers;

use App\Models\OwnUserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\JWT;
use CodeIgniter\Shield\Entities\User;

class Home extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // $headerAuthorization = explode(' ', $this->request->getServer("HTTP_AUTHORIZATION"))[1];
        // $userId = service('jwtmanager')->parse($headerAuthorization)->sub;
        // var_dump(new User(["id" => $userId]));
        // var_dump(model(OwnUserModel::class)->find($userId));
        // $authenticator = auth('jwt')->getAuthenticator();
        // var_dump($authenticator->attempt(['token' => $headerAuthorization]));
        // var_dump(auth()->user());
        // die;
        // return $this->respond(["success", "turun"], 200);

        // $headerAuthorization = explode(' ', $this->request->getServer("HTTP_AUTHORIZATION"))[1];
        // var_dump(service('jwtmanager')->parse($headerAuthorization));
        // var_dump($headerAuthorization);
        // die;
        // password google
        // frbfpeuczbjmcamt
        // $users = auth()->getProvider();
        // $user = new User([
        //     'username' => null,
        //     'email' => 'megaroy123@gmail.com',
        //     'password' => 'milea0201',
        //     'first_name' => 'Anas',
        //     'last_name' => 'Paiman',
        //     'phone_number' => '089670130349',
        //     'gender' => 'm',
        //     'birth_date' => "1965-05-12",
        //     'full_address' => 'Jalan Nanas 6a, Wage, Taman, Sidoarjo',
        //     'avatar' => 'logo.png',
        // ]);
        // $users->save($user);

        // $users->findById($users->getInsertID())->addGroup('admin')->activate();

        return view('auth/email/sendRegister');
    }
}
