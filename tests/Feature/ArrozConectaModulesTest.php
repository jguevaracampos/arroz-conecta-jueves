<?php

namespace Tests\Feature;

use App\Models\Departamento;
use App\Models\Finca;
use App\Models\Publicacion;
use App\Models\User;
use App\Models\VariedadArroz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArrozConectaModulesTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Alberto García',
            'email' => 'alberto@arrozconecta.com',
            'telefono' => '3124567890',
            'departamento' => 'Tolima',
            'municipio' => 'Saldaña',
            'vereda' => 'Camao Arriba',
            'rol' => 'agricultor',
        ]);

        $depto = Departamento::create(['nombre' => 'Tolima']);
        $depto->municipios()->create(['nombre' => 'Saldaña']);

        VariedadArroz::create([
            'nombre' => 'Fedearroz 67',
            'dias_ciclo' => 125,
            'rendimiento_estimado_ton' => 7.5,
        ]);
    }

    public function test_pantalla_bienvenida_se_muestra_correctamente(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ArrozConecta');
        $response->assertSee('Tecnología sencilla para el');
        $response->assertSee('Mi Cultivo');

    }

    public function test_dashboard_muestra_saludo_sensor_y_progreso(): void
    {
        $response = $this->actingAs($this->user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Hola, Alberto García');
        $response->assertSee('Sensor principal');
        $response->assertSee('Humedad del suelo');
        $response->assertSee('Accesos Rápidos');
    }

    public function test_modulo_mi_cultivo_puede_registrar_finca_y_lote(): void
    {
        $response = $this->actingAs($this->user)->post('/fincas', [
            'nombre' => 'Finca La Esperanza',
            'departamento' => 'Tolima',
            'municipio' => 'Saldaña',
            'vereda' => 'Camao Arriba',
            'area_total' => 10.5,
            'propietario' => 'Alberto García',
        ]);

        $response->assertRedirect('/cultivos');
        $this->assertDatabaseHas('fincas', ['nombre' => 'Finca La Esperanza']);

        $finca = Finca::first();

        $responseLote = $this->actingAs($this->user)->post('/lotes', [
            'finca_id' => $finca->id,
            'nombre' => 'Lote 1 Norte',
            'area_hectareas' => 5.0,
            'tipo_arroz' => 'Riego',
            'estado' => 'Activo',
            'fecha_siembra' => now()->subDays(45)->toDateString(),
        ]);

        $responseLote->assertRedirect('/cultivos');
        $this->assertDatabaseHas('lotes', ['nombre' => 'Lote 1 Norte']);
    }

    public function test_modulo_comunidad_crear_publicacion_comentar_y_reaccionar(): void
    {
        $response = $this->actingAs($this->user)->post('/comunidad/publicaciones', [
            'titulo' => 'Duda sobre plaga en arroz',
            'categoria' => 'Plagas y enfermedades',
            'contenido' => '¿Qué dosis recomiendan para sogata en espigamiento?',
        ]);

        $response->assertRedirect('/comunidad');
        $this->assertDatabaseHas('publicaciones', ['titulo' => 'Duda sobre plaga en arroz']);

        $pub = Publicacion::first();

        // Comentar
        $this->actingAs($this->user)->post("/comunidad/publicaciones/{$pub->id}/comentarios", [
            'contenido' => 'Recomiendo aplicar Beauveria bassiana en horas de la tarde.',
        ]);
        $this->assertDatabaseHas('comentarios', ['publicacion_id' => $pub->id]);

        // Toggle Like
        $this->actingAs($this->user)->post("/comunidad/publicaciones/{$pub->id}/reaccion");
        $this->assertEquals(1, $pub->fresh()->likes_count);
    }

    public function test_modulo_servicios_puede_publicar_servicio(): void
    {
        $response = $this->actingAs($this->user)->post('/servicios', [
            'titulo' => 'Alquiler de Tractor John Deere con Zanjeadora',
            'categoria' => 'Alquiler de tractor',
            'descripcion' => 'Tractor de 110 HP con operario en Saldaña.',
            'precio' => 140000,
            'unidad_precio' => 'por hora',
            'departamento' => 'Tolima',
            'municipio' => 'Saldaña',
            'contacto_telefono' => '3124567890',
        ]);

        $response->assertRedirect('/servicios');
        $this->assertDatabaseHas('servicios', ['titulo' => 'Alquiler de Tractor John Deere con Zanjeadora']);
    }

    public function test_api_nodemcu_esp8266_recibe_telemetria_iot(): void
    {
        $response = $this->postJson('/api/sensores/medicion', [
            'codigo_sensor' => 'ESP8266-SALDANA-01',
            'humedad_suelo' => 68.5,
            'humedad_aire' => 75.0,
            'temperatura' => 28.0,
            'ph' => 6.5,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'status' => 'success',
        ]);
        $this->assertDatabaseHas('mediciones_sensor', [
            'humedad_suelo' => 68.5,
            'humedad_aire' => 75.0,
        ]);
    }

    public function test_guia_cultivo_y_alertas_cargan_correctamente(): void
    {
        $responseGuia = $this->actingAs($this->user)->get('/guia');
        $responseGuia->assertStatus(200);
        $responseGuia->assertSee('Guía Técnica del Cultivo de Arroz');

        $responseAlertas = $this->actingAs($this->user)->get('/alertas');
        $responseAlertas->assertStatus(200);
        $responseAlertas->assertSee('Alertas y Notificaciones');
    }
}
