<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ClientesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'account_id' => Account::create(['name' => 'Acme Corporation'])->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);

        $this->user->account->clientes()->createMany([
            [
                'name' => 'Apple',
                'email' => 'info@apple.com',
                'phone' => '647-943-4400',
                'address' => '1600-120 Bremner Blvd',
                'city' => 'Toronto',
                'region' => 'ON',
                'country' => 'CA',
                'postal_code' => 'M5J 0A8',
            ], [
                'name' => 'Microsoft',
                'email' => 'info@microsoft.com',
                'phone' => '877-568-2495',
                'address' => 'One Microsoft Way',
                'city' => 'Redmond',
                'region' => 'WA',
                'country' => 'US',
                'postal_code' => '98052',
            ],
        ]);
    }

    public function test_can_view_clientes()
    {
        $this->actingAs($this->user)
            ->get('/clientes')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Clientes/Index')
                ->has('clientes.data', 2)
                ->has('clientes.data.0', fn (Assert $assert) => $assert
                    ->where('id', 1)
                    ->where('name', 'Apple')
                    ->where('phone', '647-943-4400')
                    ->where('city', 'Toronto')
                    ->where('deleted_at', null)
                )
                ->has('clientes.data.1', fn (Assert $assert) => $assert
                    ->where('id', 2)
                    ->where('name', 'Microsoft')
                    ->where('phone', '877-568-2495')
                    ->where('city', 'Redmond')
                    ->where('deleted_at', null)
                )
            );
    }

    public function test_can_search_for_clientes()
    {
        $this->actingAs($this->user)
            ->get('/clientes?search=Apple')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Clientes/Index')
                ->where('filters.search', 'Apple')
                ->has('clientes.data', 1)
                ->has('clientes.data.0', fn (Assert $assert) => $assert
                    ->where('id', 1)
                    ->where('name', 'Apple')
                    ->where('phone', '647-943-4400')
                    ->where('city', 'Toronto')
                    ->where('deleted_at', null)
                )
            );
    }

    public function test_cannot_view_deleted_clientes()
    {
        $this->user->account->clientes()->firstWhere('name', 'Microsoft')->delete();

        $this->actingAs($this->user)
            ->get('/clientes')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Clientes/Index')
                ->has('clientes.data', 1)
                ->where('clientes.data.0.name', 'Apple')
            );
    }

    public function test_can_filter_to_view_deleted_clientes()
    {
        $this->user->account->clientes()->firstWhere('name', 'Microsoft')->delete();

        $this->actingAs($this->user)
            ->get('/clientes?trashed=with')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Clientes/Index')
                ->has('clientes.data', 2)
                ->where('clientes.data.0.name', 'Apple')
                ->where('clientes.data.1.name', 'Microsoft')
            );
    }
}
