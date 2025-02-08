<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class AdminSeeder extends Seeder
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function run()
    {
        $DeveloperUser = new User([
            'username' => 'althofgerald',
            'email'    => 'althofny@gmail.com',
            'password' => 'Youngbrat5631',
        ]);

        $this->userModel->save($DeveloperUser);

        // To get the complete user object with ID, we need to get from the database
        $user = $this->userModel->findById($this->userModel->getInsertID());

        // Add user to superadmin group
        $user->addGroup('developer');

        // Activate user
        $user->activate();
    }
}
