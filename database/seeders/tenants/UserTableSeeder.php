<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Criando e-mails admin e suporte
         */
        $usersDefault = [
            [
                'id' => 1,
                'name' => 'Suporte',
                'email' => env('MAIL_FROM_ADDRESS'),
            ],
            [
                'id' => 2,
                'name' => 'Administrador',
                'email' => env('MAIL_FROM_ADMIN'),
            ],
        ];

        /*
         * Criando e-mails para testes
         */
        if (env('APP_DEBUG')) {
            $usersDefault[] = [
                'id' => 3,
                'name' => 'Usuário Teste Técnico',
                'email' => env('MAIL_FROM_TEST_TECHNICIAN'),
            ];

            $usersDefault[] = [
                'id' => 4,
                'name' => 'Usuário Teste Jogador',
                'email' => env('MAIL_FROM_TEST_PLAYER'),
            ];

            $usersDefault[] = [
                'id' => 5,
                'name' => 'Usuário Sem Permissao',
                'email' => env('MAIL_FROM_NO_PERMISSION'),
            ];
        }

        foreach ($usersDefault as $user) {
            User::updateOrCreate(
                ['id' => $user['id']],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make('password'),
                    'remember_token' => Str::random(10),
                ]
            );
        }
    }
}
