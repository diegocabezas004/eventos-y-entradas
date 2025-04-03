<?php

namespace Tests\Feature\Tickets;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuyTicketsUnauthenticatedTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cant_buy_tickets_without_being_logged_in()
    {
        // Datos necesarios para la compra del ticket (sin autenticación)
        $ticketData = [
            'event_id' => 1,  // Este ID de evento debe existir en la base de datos
            'quantity' => 1,   // La cantidad de boletos a comprar
        ];

        // Hacemos la petición POST para comprar el boleto sin estar autenticado
        $response = $this->postJson('/api/v1/tickets/buy', $ticketData);

        // Verificamos que la respuesta tenga el código de estado 401 (No autenticado)
        $response->assertStatus(401);

        // Verificamos que el mensaje de error sea 'Unauthenticated.'
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }
}
