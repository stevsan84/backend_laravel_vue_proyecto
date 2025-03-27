<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user1 = new User();
        $user1->name = "Admin";
        $user1->email = "admin@mail.com";
        $user1->password = bcrypt("admin54321");
        $user1->save();

        $user2 = new User();
        $user2->name = "Steven Gerente";
        $user2->email = "steven@mail.com";
        $user2->password = bcrypt("steven54321");
        $user2->save();

        $user3 = new User();
        $user3->name = "Wendy Cajero";
        $user3->email = "wendy@mail.com";
        $user3->password = bcrypt("wendy54321");
        $user3->save();
    }
}
