<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegisterController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Exceptions\ValidationException;
use App\Models\MitraModel;

/**
 * Class RegisterController
 *
 * Handles displaying registration form,
 * and handling actual registration flow.
 */
class RegisterController extends ShieldRegisterController
{
    use ResponseTrait;

    public function registerSeller(): ResponseInterface
    {
        helper('text');
        // Validate here first, since some things,
        // like the password, can only be validated properly here.

        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => "required|valid_email|is_unique[auth_identities.secret]",
            ],
            'first_name' => [
                'label' => 'Nama depan',
                'rules' => 'required|alpha_space|max_length[128]',
            ],
            'last_name' => [
                'label' => 'Nama belakang',
                'rules' => 'required|alpha_space|max_length[128]',
            ],
            'phone_number' => [
                'label' => 'Nomor telepon',
                'rules' => 'required|numeric|max_length[20]',
            ],
            'gender' => [
                'label' => 'Jenis kelamin',
                'rules' => 'required|in_list[m,f]',
            ],
            'birth_date' => [
                'label' => 'Tanggal lahir',
                'rules' => 'required|valid_date[Y-m-d]',
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'required|regex_match[/\A[A-Za-z0-9 ~!#$%\&\*\-_+=|:.,]+\z/]|max_length[512]',
            ],
            'mitra_name' => [
                'label' => "Nama mitra",
                'rules' => 'required|is_unique[mitra.name]|max_length[128]|alpha_numeric_punct',
            ],
            'mitra_npwp' => [
                'label' => "NPWP mitra",
                'rules' => 'permit_empty|is_unique[mitra.npwp]|alpha_numeric_punct',
            ],
            'mitra_address' => [
                'label' => 'Alamat mitra',
                'rules' => 'required|max_length[256]|regex_match[/\A[A-Za-z0-9 ~!#$%\&\*\-_+=|:.,]+\z/]',
            ],
        ];

        if (!$this->validateData($this->request->getJSON(true), $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $db = db_connect();
        $db->transBegin();
        // save company first
        $mitraModel = model(MitraModel::class);
        $mitraData = [
            'name' => $this->request->getJsonVar('mitra_name'),
            'npwp' => $this->request->getJsonVar('mitra_npwp'),
            'address' => $this->request->getJsonVar('mitra_address'),
            'avatar' => 'trendDecorationLogo.png',
        ];
        if (!$mitraModel->save($mitraData)) {
            $failed = true;
        }
        $factoryID = $mitraModel->getInsertID();



        $users = $this->getUserProvider();

        // generate random password
        $password = random_string("numeric", 5);

        // Save the user
        $user              = $this->getUserEntity();
        $user->fill([
            'email' => $this->request->getJsonVar('email'),
            'username' => null,
            'password' => $password,
            'first_name' => $this->request->getJsonVar('first_name'),
            'last_name' => $this->request->getJsonVar('last_name'),
            'phone_number' => $this->request->getJsonVar('phone_number'),
            'gender' => $this->request->getJsonVar('gender'),
            'birth_date' => $this->request->getJsonVar('birth_date'),
            'full_address' => $this->request->getJsonVar('address'),
            'avatar' => 'trendDecorationLogo.png',
            'factory_id' => $factoryID
        ]);

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        if (!$users->save($user)) {
            $failed = true;
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        $user->addGroup("seller");

        // Set the user active
        $user->activate();

        $email = emailer()
            ->setFrom(setting("Email.fromEmail"), setting('Email.fromName'))
            ->setTo($this->request->getJsonVar('email'))
            ->setSubject("Selamat, Akun Anda untuk " . $this->request->getJsonVar('mitra_name') . " Telah Aktif")
            ->setMessage(view("auth/email/sendRegister", [
                'fullname' => $this->request->getJsonVar('first_name') . " " . $this->request->getJsonVar('last_name'),
                'mitraName' => $this->request->getJsonVar('mitra_name'),
                'activeDate' => implode(" ", [date('j'), $this->getMonth((int)date("m")), date("Y")]),
                'email' => $this->request->getJsonVar('email'),
                'password' => $password,
            ]));

        $result = $email->send();

        if ($db->transStatus() === false || ($failed ?? false) || !$result) {
            $db->transRollback();
            log_message('error', json_encode($db->error()));
            log_message('error', json_encode([$result, $email->printDebugger()]));
            return $this->failServerError();
        }

        $db->transCommit();

        // Success!
        return $this->respondCreated([
            'status_code' => 201,
            'message' => 'User has been created!',
        ]);
    }

    public function sendPassword()
    {
        // $config['fromEmail'] = setting('Email.FromEmail');
        // $config['fromName'] = setting('Email.fromName');
        // $config['SMTPUser'] = setting('Email.SMTPUser');
        // $config['SMTPPass'] = setting('Email.SMTPPass');
        // emailer()
        //     ->setTo("mochamadroiyan@gmail.com")
        //     ->setSubject("Percobaan kirim email")
        //     ->setMessage("Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim aperiam aliquid, quaerat exercitationem quasi dolorem pariatur provident minus optio officiis ut mollitia impedit minima reiciendis porro corrupti, cumque assumenda blanditiis incidunt facere rem recusandae est ratione ad. Nobis ab illum sit nam quod! Soluta, porro? Nesciunt id dignissimos quisquam sunt quas minus quis laboriosam nam, consequatur, voluptas ad ut quaerat omnis eaque officia reiciendis quo cumque velit vero neque? Officia dolorum sunt iure, totam ea modi numquam iusto. Totam sed, placeat fuga deleniti quaerat, beatae fugit, iste a cumque non odio voluptatum asperiores dolores? Facere illo reiciendis minus enim tempora!");
    }

    private function getMonth(int $monthId)
    {
        $listMonth = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
        return ucfirst($listMonth[$monthId - 1]);
    }
}
