<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ContactosTest extends TestCase
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

        $cliente = $this->user->account->clientes()->create(['name' => 'Example Cliente Inc.']);

        $this->user->account->contactos()->createMany([
            [
                'cliente_id' => $cliente->id,
                'first_name' => 'Martin',
                'last_name' => 'Abbott',
                'email' => 'martin.abbott@example.com',
                'phone' => '555-111-2222',
                'address' => '330 Glenda Shore',
                'city' => 'Murphyland',
                'region' => 'Tennessee',
                'country' => 'US',
                'postal_code' => '57851',
            ], [
                'cliente_id' => $cliente->id,
                'first_name' => 'Lynn',
                'last_name' => 'Kub',
                'email' => 'lynn.kub@example.com',
                'phone' => '555-333-4444',
                'address' => '199 Connelly Turnpike',
                'city' => 'Woodstock',
                'region' => 'Colorado',
                'country' => 'US',
                'postal_code' => '11623',
            ],
        ]);
    }

    public function test_can_view_contactos()
    {
        $this->actingAs($this->user)
            ->get('/contactos')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Contactos/Index')
                ->has('contactos.data', 2)
                ->has('contactos.data.0', fn (Assert $assert) => $assert
                    ->where('id', 1)
                    ->where('name', 'Martin Abbott')
                    ->where('phone', '555-111-2222')
                    ->where('city', 'Murphyland')
                    ->where('deleted_at', null)
                    ->has('cliente', fn (Assert $assert) => $assert
                        ->where('name', 'Example Cliente Inc.')
                    )
                )
                ->has('contactos.data.1', fn (Assert $assert) => $assert
                    ->where('id', 2)
                    ->where('name', 'Lynn Kub')
                    ->where('phone', '555-333-4444')
                    ->where('city', 'Woodstock')
                    ->where('deleted_at', null)
                    ->has('cliente', fn (Assert $assert) => $assert
                        ->where('name', 'Example Cliente Inc.')
                    )
                )
            );
    }

    public function test_can_search_for_contactos()
    {
        $this->actingAs($this->user)
            ->get('/contactos?search=Martin')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Contactos/Index')
                ->where('filters.search', 'Martin')
                ->has('contactos.data', 1)
                ->has('contactos.data.0', fn (Assert $assert) => $assert
                    ->where('id', 1)
                    ->where('name', 'Martin Abbott')
                    ->where('phone', '555-111-2222')
                    ->where('city', 'Murphyland')
                    ->where('deleted_at', null)
                    ->has('cliente', fn (Assert $assert) => $assert
                        ->where('name', 'Example Cliente Inc.')
                    )
                )
            );
    }

    public function test_cannot_view_deleted_contactos()
    {
        $this->user->account->contactos()->firstWhere('first_name', 'Martin')->delete();

        $this->actingAs($this->user)
            ->get('/contactos')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Contactos/Index')
                ->has('contactos.data', 1)
                ->where('contactos.data.0.name', 'Lynn Kub')
            );
    }

    public function test_can_filter_to_view_deleted_contactos()
    {
        $this->user->account->contactos()->firstWhere('first_name', 'Martin')->delete();

        $this->actingAs($this->user)
            ->get('/contactos?trashed=with')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Contactos/Index')
                ->has('contactos.data', 2)
                ->where('contactos.data.0.name', 'Martin Abbott')
                ->where('contactos.data.1.name', 'Lynn Kub')
            );
    }
}
