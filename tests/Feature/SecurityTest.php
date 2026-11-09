<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_page_is_displayed_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/configuracion');

        $response->assertOk();
        $response->assertSee('Configuración & Seguridad');
        $response->assertSee('Restablecer Contraseña');
        $response->assertSee('Generar *(6 códigos)');
    }

    public function test_user_can_update_password_from_security_page(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password123'),
        ]);

        $response = $this->actingAs($user)->put('/configuracion/password', [
            'current_password' => 'old-password123',
            'password' => 'New-password456!',
            'password_confirmation' => 'New-password456!',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertTrue(Hash::check('New-password456!', $user->fresh()->password));

    }

    public function test_user_can_generate_six_recovery_codes(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/configuracion/recovery-codes');

        $response->assertRedirect();
        $response->assertSessionHas('plain_recovery_codes');

        $plainCodes = session('plain_recovery_codes');
        $this->assertCount(6, $plainCodes);

        $freshUser = $user->fresh();
        $this->assertNotNull($freshUser->recovery_codes);
        $this->assertCount(6, $freshUser->recovery_codes);

        // Verifica que los códigos en BD estén hasheados
        $this->assertTrue(Hash::check($plainCodes[0], $freshUser->recovery_codes[0]['code']));
        $this->assertFalse($freshUser->recovery_codes[0]['used']);
    }

    public function test_user_can_download_recovery_codes_txt_file(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/configuracion/recovery-codes');

        $response = $this->actingAs($user)->get('/configuracion/recovery-codes/descargar');

        $response->assertOk();
        $this->assertStringContainsString('text/plain', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment;', $response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('TUS 6 CÓDIGOS DE RECUPERACIÓN', $response->getContent());
    }

    public function test_user_can_authenticate_with_recovery_code(): void
    {
        $user = User::factory()->create();

        // Generar códigos
        $this->actingAs($user)->post('/configuracion/recovery-codes');
        $plainCodes = session('plain_recovery_codes');
        $firstCode = $plainCodes[0];

        // Cerrar sesión
        $this->post('/logout');
        $this->assertGuest();

        // Iniciar sesión con el primer código de recuperación
        $response = $this->post('/login/recovery-code', [
            'email' => $user->email,
            'recovery_code' => $firstCode,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        // Verificar que el código utilizado quedó quemado/usado
        $freshUser = $user->fresh();
        $this->assertTrue($freshUser->recovery_codes[0]['used']);
        $this->assertNotNull($freshUser->recovery_codes[0]['used_at']);
    }
}
