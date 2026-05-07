<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = new User;
        $user1->nama_lengkap = 'Donal tram';
        $user1->email = 'donal@mail.com';
        $user1->password = Hash::make('a1b2c');
        $user1->role = 'admin';
        $user1->save();

        $user2 = new User;
        $user2->nama_lengkap = 'Jikowo Didi';
        $user2->email = 'jikowo@mail.com';
        $user2->password = Hash::make('x9y8z');
        $user2->role = 'investor';
        $user2->save();

        $user3 = new User;
        $user3->nama_lengkap = 'Prabroro Subanto';
        $user3->email = 'prabroro@mail.com';
        $user3->password = Hash::make('p7q6r');
        $user3->role = 'investor';
        $user3->save();

        $user4 = new User;
        $user4->nama_lengkap = 'Masinis Edan';
        $user4->email = 'masinis@mail.com';
        $user4->password = Hash::make('m1n2s');
        $user4->role = 'investor';
        $user4->save();

        $user5 = new User;
        $user5->nama_lengkap = 'Megacan Putri';
        $user5->email = 'megacan@mail.com';
        $user5->password = Hash::make('m3g4p');
        $user5->role = 'investor';
        $user5->save();

        $user6 = new User;
        $user6->nama_lengkap = 'Genjer Pranowi';
        $user6->email = 'genjer@mail.com';
        $user6->password = Hash::make('g5n6r');
        $user6->role = 'investor';
        $user6->save();
    }
}