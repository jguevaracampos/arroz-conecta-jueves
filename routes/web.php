<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuiaCultivoController;
use App\Http\Controllers\MonitoreoController;
use App\Http\Controllers\PerfilAgricultorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;

// 1. Pantalla de Bienvenida (Página 16 del documento)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Endpoint API para NodeMCU ESP8266 (IoT)
Route::post('/api/sensores/medicion', [MonitoreoController::class, 'registrarMedicionIoT'])->name('api.sensores.medicion');

// Acceso de emergencia para invitados usando código de recuperación
Route::middleware('guest')->group(function () {
    Route::get('/login/recovery-code', [SecurityController::class, 'showRecoveryLogin'])->name('login.recovery');
    Route::post('/login/recovery-code', [SecurityController::class, 'loginWithRecoveryCode'])->name('login.recovery.store');
});

// Rutas protegidas para agricultores autenticados
Route::middleware(['auth'])->group(function () {

    // 2. Dashboard o Inicio (Páginas 17-18 del documento)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 3. Mi Cultivo (Fincas, Lotes, Cultivos y Progreso Fenológico)
    Route::get('/cultivos', [CultivoController::class, 'index'])->name('cultivos.index');
    Route::post('/fincas', [CultivoController::class, 'storeFinca'])->name('fincas.store');
    Route::delete('/fincas/{finca}', [CultivoController::class, 'destroyFinca'])->name('fincas.destroy');
    Route::post('/lotes', [CultivoController::class, 'storeLote'])->name('lotes.store');
    Route::delete('/lotes/{lote}', [CultivoController::class, 'destroyLote'])->name('lotes.destroy');
    Route::post('/cultivos', [CultivoController::class, 'storeCultivo'])->name('cultivos.store');
    Route::delete('/cultivos/{cultivo}', [CultivoController::class, 'destroyCultivo'])->name('cultivos.destroy');

    // 4. Comunidad (Red Social Arrocera)
    Route::get('/comunidad', [ComunidadController::class, 'index'])->name('comunidad.index');
    Route::post('/comunidad/publicaciones', [ComunidadController::class, 'store'])->name('comunidad.store');
    Route::post('/comunidad/publicaciones/{publicacion}/comentarios', [ComunidadController::class, 'storeComment'])->name('comunidad.comentarios.store');
    Route::post('/comunidad/publicaciones/{publicacion}/reaccion', [ComunidadController::class, 'toggleLike'])->name('comunidad.reaccion');
    Route::post('/comunidad/publicaciones/{publicacion}/reportar', [ComunidadController::class, 'reportar'])->name('comunidad.reportar');
    Route::delete('/comunidad/publicaciones/{publicacion}', [ComunidadController::class, 'destroy'])->name('comunidad.destroy');

    // 5. Servicios (Mercado de Maquinaria, Transporte y Mano de Obra)
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
    Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
    Route::patch('/servicios/{servicio}/toggle', [ServicioController::class, 'toggleDisponibilidad'])->name('servicios.toggle');
    Route::delete('/servicios/{servicio}', [ServicioController::class, 'destroy'])->name('servicios.destroy');

    // 6. Monitoreo (Sensores IoT ESP8266, Gráficas de Humedad 24h, pH y Temperatura)
    Route::get('/monitoreo', [MonitoreoController::class, 'index'])->name('monitoreo.index');
    Route::post('/monitoreo/simular', [MonitoreoController::class, 'simularLectura'])->name('monitoreo.simular');

    // 7. Perfil del Agricultor
    Route::get('/perfil', [PerfilAgricultorController::class, 'index'])->name('perfil.index');
    Route::post('/perfil', [PerfilAgricultorController::class, 'update'])->name('perfil.update');

    // 8. Guía del Cultivo (Biblioteca Agronómica por 6 Etapas)
    Route::get('/guia', [GuiaCultivoController::class, 'index'])->name('guia.index');
    Route::get('/guia/{guia}', [GuiaCultivoController::class, 'show'])->name('guia.show');

    // 9. Alertas y Notificaciones
    Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');
    Route::post('/alertas/{notificacion}/leida', [AlertaController::class, 'marcarLeida'])->name('alertas.marcar-leida');
    Route::post('/alertas/marcar-todas', [AlertaController::class, 'marcarTodasLeidas'])->name('alertas.marcar-todas');
    Route::delete('/alertas/{notificacion}', [AlertaController::class, 'destroy'])->name('alertas.destroy');

    // 10. Administración de la Plataforma
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::patch('/admin/usuarios/{targetUser}/rol', [AdminController::class, 'cambiarRol'])->name('admin.usuarios.rol');
    Route::patch('/admin/publicaciones/{publicacion}/descartar', [AdminController::class, 'descartarReporte'])->name('admin.publicaciones.descartar');

    // Configuración y Perfil Breeze original (conservado íntegro)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Configuración -> Blindaje / Hardening (Estilo Proton) conservado íntegro
    Route::get('/configuracion', [SecurityController::class, 'index'])->name('configuracion.index');
    Route::get('/configuracion/seguridad', [SecurityController::class, 'index'])->name('seguridad.index');
    Route::put('/configuracion/password', [SecurityController::class, 'updatePassword'])->name('seguridad.password');
    Route::post('/configuracion/recovery-codes', [SecurityController::class, 'generateRecoveryCodes'])->name('seguridad.codes.generate');
    Route::get('/configuracion/recovery-codes/descargar', [SecurityController::class, 'downloadRecoveryCodes'])->name('seguridad.codes.download');
});

require __DIR__.'/auth.php';
