<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contacto;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['name' => 'Acme Corporation']);

        User::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'owner' => true,
        ]);

        User::factory(5)->create(['account_id' => $account->id]);

        $clientes = Cliente::factory(100)
            ->create(['account_id' => $account->id]);

        Contacto::factory(100)
            ->create(['account_id' => $account->id])
            ->each(function ($contacto) use ($clientes) {
                $contacto->update(['cliente_id' => $clientes->random()->id]);
            });
    }
}
