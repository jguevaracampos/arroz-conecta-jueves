<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\ConsejoSemanal;
use App\Models\Cultivo;
use App\Models\Departamento;
use App\Models\EtapaFenologica;
use App\Models\Finca;
use App\Models\GuiaCultivo;
use App\Models\Lote;
use App\Models\MedicionSensor;
use App\Models\Municipio;
use App\Models\Notificacion;
use App\Models\Publicacion;
use App\Models\Sensor;
use App\Models\Servicio;
use App\Models\User;
use App\Models\VariedadArroz;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArrozConectaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Departamentos y Municipios arroceros de Colombia
        $deptos = [
            'Tolima' => ['Saldaña', 'El Espinal', 'Purificación', 'Campoalegre', 'Ibagué', 'Guamo', 'Lérida', 'Venadillo'],
            'Huila' => ['Campoalegre', 'Neiva', 'Palermo', 'Villavieja', 'Rivera'],
            'Casanare' => ['Yopal', 'Aguazul', 'Tauramena', 'Villanueva', 'Maní'],
            'Meta' => ['Villavicencio', 'Granada', 'Acacías', 'San Martín', 'Puerto López'],
            'Córdoba' => ['Montería', 'Cereté', 'Ciénaga de Oro', 'Lorica'],
            'Norte de Santander' => ['Cúcuta', 'El Zulia', 'Tibú'],
        ];

        foreach ($deptos as $deptoNombre => $municipios) {
            $depto = Departamento::firstOrCreate(['nombre' => $deptoNombre]);
            foreach ($municipios as $muniNombre) {
                Municipio::firstOrCreate([
                    'departamento_id' => $depto->id,
                    'nombre' => $muniNombre,
                ]);
            }
        }

        // 2. Variedades de Arroz
        $variedades = [
            [
                'nombre' => 'Fedearroz 67',
                'dias_ciclo' => 125,
                'descripcion' => 'Excelente calidad de grano, buen macollamiento y alta tolerancia al volcamiento.',
                'rendimiento_estimado_ton' => 7.8,
            ],
            [
                'nombre' => 'Diana',
                'dias_ciclo' => 120,
                'descripcion' => 'Variedad tradicional de gran aceptación molinera en la cuenca del río Saldaña.',
                'rendimiento_estimado_ton' => 7.2,
            ],
            [
                'nombre' => 'Fedearroz 2000',
                'dias_ciclo' => 130,
                'descripcion' => 'Reconocida por su resistencia a Pyricularia y alto potencial en suelos del Tolima Grande.',
                'rendimiento_estimado_ton' => 8.1,
            ],
            [
                'nombre' => 'Fedearroz 68',
                'dias_ciclo' => 128,
                'descripcion' => 'Variedad moderna con vigor inicial superior y tolerancia a estrés hídrico moderado.',
                'rendimiento_estimado_ton' => 8.0,
            ],
            [
                'nombre' => 'Fedearroz Ibis 4',
                'dias_ciclo' => 122,
                'descripcion' => 'Ciclo intermedio con grano extra largo y blanco cristalino.',
                'rendimiento_estimado_ton' => 7.6,
            ],
        ];

        foreach ($variedades as $v) {
            VariedadArroz::firstOrCreate(['nombre' => $v['nombre']], $v);
        }

        // 3. Etapas Fenológicas
        $etapas = [
            [
                'orden' => 1,
                'nombre' => 'Germinación y Emergencia',
                'rango_dias' => '0 a 15 días',
                'porcentaje_inicio' => 0,
                'porcentaje_fin' => 15,
                'descripcion' => 'Aparición del coleóptilo y las primeras hojas. Fase crítica de absorción de agua y protección de plántulas.',
                'recomendaciones' => 'Mantener el suelo con humedad uniforme sin encharcamientos prolongados para evitar asfixia radicular.',
            ],
            [
                'orden' => 2,
                'nombre' => 'Macollamiento',
                'rango_dias' => '16 a 45 días',
                'porcentaje_inicio' => 16,
                'porcentaje_fin' => 45,
                'descripcion' => 'Emisión activa de tallos secundarios y terciarios. Se define el número potencial de panículas por metro cuadrado.',
                'recomendaciones' => 'Primera y segunda fertilización nitrogenada. Mantener lámina de agua de 3 a 5 cm.',
            ],
            [
                'orden' => 3,
                'nombre' => 'Iniciación Panicular / Embuche',
                'rango_dias' => '46 a 75 días',
                'porcentaje_inicio' => 46,
                'porcentaje_fin' => 70,
                'descripcion' => 'Diferenciación del primordio floral y engrosamiento de la vaina (hoja bandera). Demanda máxima de nutrientes.',
                'recomendaciones' => 'Aplicación de potasio y fósforo. Monitoreo intensivo de Pyricularia y manchado de grano.',
            ],
            [
                'orden' => 4,
                'nombre' => 'Floración y Antesis',
                'rango_dias' => '76 a 95 días',
                'porcentaje_inicio' => 71,
                'porcentaje_fin' => 85,
                'descripcion' => 'Apertura de espiguillas y polinización. Sensible a temperaturas extremas y déficit de agua.',
                'recomendaciones' => 'Evitar estrés hídrico bajo ningún motivo. No realizar aplicaciones agresivas en horas matutinas.',
            ],
            [
                'orden' => 5,
                'nombre' => 'Maduración y Cosecha',
                'rango_dias' => '96 a 130 días',
                'porcentaje_inicio' => 86,
                'porcentaje_fin' => 100,
                'descripcion' => 'Llenado y endurecimiento del grano (lechoso, pastoso y duro). Descenso de la humedad del grano al 20-22%.',
                'recomendaciones' => 'Drenar el lote 10 a 15 días antes de la cosecha para facilitar la entrada de cosechadoras combinadas.',
            ],
        ];

        foreach ($etapas as $e) {
            EtapaFenologica::firstOrCreate(['orden' => $e['orden']], $e);
        }

        // 4. Guías del Cultivo por Etapas
        $guias = [
            [
                'etapa' => 'Preparación del terreno',
                'titulo' => 'Limpieza, Arado y Nivelación Láser del Terreno',
                'resumen' => 'Aprende a preparar el suelo arrocero para optimizar el uso del agua y reducir malezas.',
                'contenido' => 'La adecuada preparación del suelo es el 50% del éxito en el cultivo de arroz bajo riego.

1. Limpieza de restos de cosecha anterior: Realizar picado e incorporación de tamo para devolver materia orgánica al suelo.
2. Arado y rastrillado: Permitir una profundidad efectiva de 20 a 25 cm para facilitar el anclaje radicular.
3. Nivelación con Land Plane o Láser: En la zona de Saldaña y Espinal, la nivelación de precisión reduce hasta un 30% el consumo de agua por hectárea y garantiza una lámina homogénea.
4. Construcción de caballones y taipas: Diseñar los desagües y entradas de agua para un drenaje oportuno ante lluvias intensas.',
                'icono' => '🚜',
                'consejos_clave' => "Evitar sobre-mecanizar el suelo cuando esté demasiado húmedo para no compactar el subsuelo.\nComprobar la pendiente de las taipas antes de inundar.",
            ],
            [
                'etapa' => 'Siembra',
                'titulo' => 'Selección de Semilla Certificada y Densidad de Siembra',
                'resumen' => 'Parámetros técnicos de germinación, tratamiento de semilla y calibración de sembradoras.',
                'contenido' => 'Sembrar arroz con semilla certificada garantiza vigor híbrido, pureza varietal y ausencia de arroz rojo.

- Variedades recomendadas: Fedearroz 67, Diana y Fedearroz 2000 según tipo de suelo y disponibilidad hídrica.
- Densidad de siembra:
  • Siembra mecanizada en líneas: 100 a 120 kg/ha.
  • Siembra al voleo pre-germinada: 130 a 150 kg/ha.
- Tratamiento de semilla: Aplicar insecticida curasemillas para proteger de gusano picador y pulgón en los primeros 12 días.',
                'icono' => '🌱',
                'consejos_clave' => "Realizar prueba de germinación en toalla húmeda antes de sembrar; debe superar el 85%.\nProfundidad ideal de semilla: entre 2 y 3 cm.",
            ],
            [
                'etapa' => 'Riego',
                'titulo' => 'Manejo Eficiente del Agua y Lámina de Inundación',
                'resumen' => 'Control de humedad con sensores IoT para maximizar macollamiento y reducir consumo.',
                'contenido' => 'El arroz no es una planta acuática, sino una planta con alta tolerancia al agua.

- Etapa de 0 a 15 días: Riego por gravedad intermitente (mojes rápidos sin encharque permanente).
- Macollamiento (16 a 45 días): Establecer lámina delgada de 3 a 5 cm para frenar malezas y estimular hijuelos.
- Embuche y Floración: Lámina constante de 5 a 7 cm. El estrés hídrico en floración produce espiguillas vanas (albinismo).
- Sensores IoT: La lectura capacitiva recomendada en el suelo debe mantenerse entre 65% y 80% de humedad.',
                'icono' => '💧',
                'consejos_clave' => "No descuidar el agua 15 días antes y 10 días después de la floración.\nDrenar 12 días antes de cortar para evitar hundimiento de maquinaria.",
            ],
            [
                'etapa' => 'Fertilización',
                'titulo' => 'Plan Nutricional: Nitrógeno, Fósforo, Potasio y Silicio',
                'resumen' => 'Momentos clave de aplicación para lograr más de 7 toneladas por hectárea.',
                'contenido' => 'Un plan de abonamiento equilibrado se basa en el análisis de suelo:

1. Siembra o emergencia (10-12 días): Fósforo completo (DAP) + Zinc + Silicio para estimular raíz.
2. Pleno macollamiento (25-30 días): 30% del Nitrógeno total (Urea) + Azufre.
3. Máximo macollamiento (40-45 días): 35% del Nitrógeno + Potasio (KCL).
4. Embuche (60-65 días): 35% restante de Nitrógeno + Potasio restante para llenado de panícula.
5. Aplicación foliar de boro y silicio para endurecer el tallo contra el volcamiento.',
                'icono' => '🌾',
                'consejos_clave' => "Aplicar el fertilizante nitrogenado siempre con el lote drenado y meter el agua 24 a 48 horas después.\nFraccionar el nitrógeno en al menos 3 épocas.",
            ],
            [
                'etapa' => 'Control de plagas y enfermedades',
                'titulo' => 'Manejo Integrado de Sogata, Spodoptera y Pyricularia',
                'resumen' => 'Identificación temprana, umbrales de daño económico y control biológico.',
                'contenido' => 'Monitoreo semanal para evitar daños severos:

- Sogata (Tagosodes orizicolus): Vector del virus de la hoja blanca (VHB). Monitorear con jáquima; umbral: 2 a 3 insectos por pase.
- Gusano cogollero (Spodoptera frugiperda): Ataca en estado plántula. Aplicar Bacillus thuringiensis o reguladores de crecimiento.
- Pyricularia oryzae: Hongo destructivo en hoja y cuello de panícula. Aparece con exceso de nitrógeno y alta humedad relativa (>85%).
- Manchado de grano: Complejo de hongos como Bipolaris y Sarocladium. Requiere aplicación preventiva en embuche.',
                'icono' => '🔬',
                'consejos_clave' => "Evitar sobredosis de urea, que ablanda los tejidos y hace la planta vulnerable a Pyricularia.\nFomentar enemigos naturales como arañas y avispitas Trichogramma.",
            ],
            [
                'etapa' => 'Cosecha',
                'titulo' => 'Determinación del Momento Óptimo y Reducción de Pérdidas',
                'resumen' => 'Monitoreo de humedad de grano (20-22%) y calibración de combinadas.',
                'contenido' => 'La cosecha en el momento exacto asegura el mayor porcentaje de grano entero en el molino.

1. Identificación del momento: Cuando el 85% de las panículas del lote presenten color pajizo y los granos basales estén duros.
2. Medición de humedad de grano: Entre 20% y 23% de humedad. Cosechar con menos del 18% aumenta el grano partido en molienda.
3. Velocidad de la cosechadora: Calibrar cilindro desgranador y velocidad de avance para no perder grano por la cola.
4. Logística de transporte: Evitar demoras mayores a 18 horas entre corte y descargue en el molino para prevenir fermentación.',
                'icono' => '📦',
                'consejos_clave' => "Muestrear la humedad en diferentes puntos del lote antes de autorizar la entrada de la combinada.\nLimpiar las tolvas para no mezclar variedades.",
            ],
        ];

        foreach ($guias as $g) {
            GuiaCultivo::firstOrCreate(['titulo' => $g['titulo']], $g);
        }

        // 5. Consejo Semanal
        ConsejoSemanal::firstOrCreate([
            'titulo' => 'Ajuste de Riego ante Variación Térmica en el Valle del Magdalena',
        ], [
            'titulo' => 'Ajuste de Riego ante Variación Térmica en el Valle del Magdalena',
            'consejo' => 'Durante esta semana se prevén temperaturas diurnas superiores a los 36°C en Saldaña y El Espinal. Se aconseja mantener láminas de agua de 5 cm en lotes que estén en etapa de embuche y floración para amortiguar el golpe térmico y evitar grano vano.',
            'autor' => 'Ing. Alberto García · Asesor Fedearroz Tolima',
            'etapa_relevante' => 'Riego y Floración',
            'activo' => true,
        ]);

        // 6. Configurar o actualizar el usuario de Johan o primer usuario
        $usuario = User::where('email', 'johandavidguevaracampos@gmail.com')->first()
            ?? User::first();

        if ($usuario) {
            $usuario->update([
                'telefono' => '3124567890',
                'departamento' => 'Tolima',
                'municipio' => 'Saldaña',
                'vereda' => 'Camao Arriba',
                'direccion' => 'Hacienda San José, Km 4 Vía Saldaña - Purificación',
                'rol' => 'administrador',
                'data_policy_accepted_at' => now(),
            ]);

            // Finca de Johan
            $finca = Finca::firstOrCreate([
                'user_id' => $usuario->id,
                'nombre' => 'Finca La Esperanza',
            ], [
                'departamento' => 'Tolima',
                'municipio' => 'Saldaña',
                'vereda' => 'Camao Arriba',
                'direccion' => 'Km 4 Vía Saldaña - Purificación',
                'area_total' => 15.5,
                'propietario' => $usuario->name,
            ]);

            $varDiana = VariedadArroz::where('nombre', 'Diana')->first();
            $var67 = VariedadArroz::where('nombre', 'Fedearroz 67')->first();
            $var2000 = VariedadArroz::where('nombre', 'Fedearroz 2000')->first();

            // Lote 1
            $lote1 = Lote::firstOrCreate([
                'finca_id' => $finca->id,
                'nombre' => 'Lote La Esperanza',
            ], [
                'area_hectareas' => 5.0,
                'tipo_arroz' => 'Riego',
                'variedad_arroz_id' => $var67?->id,
                'variedad_nombre' => 'Fedearroz 67',
                'fecha_siembra' => Carbon::now()->subDays(45)->toDateString(),
                'estado' => 'Activo',
                'notas' => 'Lote con riego por compuerta del Distrito de Riego USOSALDAÑA.',
            ]);

            // Lote 2
            $lote2 = Lote::firstOrCreate([
                'finca_id' => $finca->id,
                'nombre' => 'Lote El Porvenir',
            ], [
                'area_hectareas' => 3.5,
                'tipo_arroz' => 'Riego',
                'variedad_arroz_id' => $varDiana?->id,
                'variedad_nombre' => 'Diana',
                'fecha_siembra' => Carbon::now()->subDays(20)->toDateString(),
                'estado' => 'Activo',
                'notas' => 'Suelo franco arcilloso, sembrado con Diana para molinería.',
            ]);

            // Lote 3
            $lote3 = Lote::firstOrCreate([
                'finca_id' => $finca->id,
                'nombre' => 'Lote El Progreso',
            ], [
                'area_hectareas' => 4.0,
                'tipo_arroz' => 'Riego',
                'variedad_arroz_id' => $var2000?->id,
                'variedad_nombre' => 'Fedearroz 2000',
                'fecha_siembra' => Carbon::now()->subDays(5)->toDateString(),
                'estado' => 'En preparación',
                'notas' => 'En nivelación láser y aplicación de enmiendas.',
            ]);

            // Cultivo activo de Johan
            $cultivo = Cultivo::firstOrCreate([
                'user_id' => $usuario->id,
                'lote_id' => $lote1->id,
            ], [
                'variedad_arroz_id' => $varDiana?->id,
                'nombre_cultivo' => 'Cultivo Arroz Diana',
                'variedad_nombre' => 'Arroz Diana',
                'fecha_siembra' => Carbon::now()->subDays(45)->toDateString(),
                'fecha_estimada_cosecha' => Carbon::now()->addDays(75)->toDateString(),
                'area_sembrada' => 5.0,
                'etapa_actual' => 'Macollamiento',
                'progreso_porcentaje' => 35,
                'dias_transcurridos' => 45,
                'estado' => 'Activo',
                'observaciones' => 'Buen macollamiento, sin presencia de plagas. Sensor de humedad activo.',
            ]);

            // Sensor IoT físico / simulado
            $sensor = Sensor::firstOrCreate([
                'codigo_sensor' => 'ESP8266-SALDANA-01',
            ], [
                'user_id' => $usuario->id,
                'lote_id' => $lote1->id,
                'nombre' => 'Sensor Capacitivo Lote La Esperanza',
                'tipo' => 'NodeMCU ESP8266 + Higrómetro + Temp + pH',
                'estado' => 'activo',
                'bateria_porcentaje' => 92,
                'ultima_conexion' => now(),
            ]);

            // Mediciones de las últimas 24 horas para la gráfica
            if ($sensor->mediciones()->count() === 0) {
                $puntos = [
                    ['hora' => 24, 'hum_suelo' => 64.0, 'hum_aire' => 80.0, 'temp' => 24.5, 'ph' => 6.4],
                    ['hora' => 20, 'hum_suelo' => 65.5, 'hum_aire' => 78.0, 'temp' => 25.2, 'ph' => 6.4],
                    ['hora' => 16, 'hum_suelo' => 67.0, 'hum_aire' => 74.0, 'temp' => 27.0, 'ph' => 6.5],
                    ['hora' => 12, 'hum_suelo' => 70.0, 'hum_aire' => 68.0, 'temp' => 31.5, 'ph' => 6.5],
                    ['hora' => 8,  'hum_suelo' => 69.2, 'hum_aire' => 71.0, 'temp' => 30.0, 'ph' => 6.5],
                    ['hora' => 4,  'hum_suelo' => 68.5, 'hum_aire' => 73.0, 'temp' => 29.1, 'ph' => 6.5],
                    ['hora' => 1,  'hum_suelo' => 68.0, 'hum_aire' => 75.0, 'temp' => 28.0, 'ph' => 6.5],
                ];

                foreach ($puntos as $pt) {
                    MedicionSensor::create([
                        'sensor_id' => $sensor->id,
                        'lote_id' => $lote1->id,
                        'humedad_suelo' => $pt['hum_suelo'],
                        'humedad_aire' => $pt['hum_aire'],
                        'temperatura' => $pt['temp'],
                        'ph' => $pt['ph'],
                        'estado_humedad' => 'Adecuada',
                        'origen' => 'iot_nodemcu',
                        'created_at' => Carbon::now()->subHours($pt['hora']),
                        'updated_at' => Carbon::now()->subHours($pt['hora']),
                    ]);
                }
            }

            // Notificaciones de ejemplo
            Notificacion::firstOrCreate([
                'user_id' => $usuario->id,
                'titulo' => 'Recordatorio de Fertilización',
            ], [
                'cultivo_id' => $cultivo->id,
                'tipo' => 'fertilizacion',
                'titulo' => 'Recordatorio de Fertilización',
                'mensaje' => 'Recuerda que mañana debes realizar la segunda fertilización nitrogenada (Urea + KCL) en el Lote La Esperanza.',
                'nivel' => 'advertencia',
                'leida' => false,
                'fecha_evento' => Carbon::tomorrow()->setHour(7),
            ]);

            Notificacion::firstOrCreate([
                'user_id' => $usuario->id,
                'titulo' => 'Sensor de Humedad Óptimo',
            ], [
                'cultivo_id' => $cultivo->id,
                'tipo' => 'humedad',
                'titulo' => 'Sensor de Humedad Óptimo',
                'mensaje' => 'La humedad del suelo en Lote La Esperanza se mantiene en 68%, dentro del rango óptimo para Macollamiento.',
                'nivel' => 'exito',
                'leida' => false,
                'fecha_evento' => Carbon::now()->subHours(2),
            ]);

            // Publicaciones de Comunidad
            $pub1 = Publicacion::firstOrCreate([
                'titulo' => '¿Alguien ha probado el control biológico de Sogata con hongos entomopatógenos?',
            ], [
                'user_id' => $usuario->id,
                'categoria' => 'Plagas y enfermedades',
                'titulo' => '¿Alguien ha probado el control biológico de Sogata con hongos entomopatógenos?',
                'contenido' => 'Buenos días compañeros arroceros de Saldaña y Espinal. En el lote La Esperanza empecé a notar un foco leve de sogata. Quiero evitar meter químicos fuertes para no dañar las arañas depredadoras. ¿Qué experiencia han tenido con Beauveria bassiana o Metarhizium en arroz Diana?',
                'likes_count' => 5,
            ]);

            Comentario::firstOrCreate([
                'publicacion_id' => $pub1->id,
                'contenido' => 'Hola Johan, yo lo apliqué en Campoalegre en horas de la tarde con humedad relativa alta y me funcionó excelente, bajó la población en 4 días sin quemar follaje.',
            ], [
                'user_id' => $usuario->id,
                'contenido' => 'Hola Johan, yo lo apliqué en Campoalegre en horas de la tarde con humedad relativa alta y me funcionó excelente, bajó la población en 4 días sin quemar follaje.',
            ]);

            Publicacion::firstOrCreate([
                'titulo' => 'Excelente resultado con nivelación láser en suelo pesado',
            ], [
                'user_id' => $usuario->id,
                'categoria' => 'Experiencias agrícolas',
                'titulo' => 'Excelente resultado con nivelación láser en suelo pesado',
                'contenido' => 'Comparto con la comunidad que este semestre nivelamos 5 hectáreas con láser y la lámina de riego entró perfecta en menos de 3 horas. El ahorro de combustible en bombeo fue notable.',
                'likes_count' => 8,
            ]);

            // Servicios agrícolas publicados
            Servicio::firstOrCreate([
                'titulo' => 'Alquiler de Tractor John Deere 6110M con Rastra y Zanjeadora',
            ], [
                'user_id' => $usuario->id,
                'titulo' => 'Alquiler de Tractor John Deere 6110M con Rastra y Zanjeadora',
                'categoria' => 'Alquiler de tractor',
                'descripcion' => 'Tractor en óptimas condiciones mecánicas con operador experimentado. Especial para batido, rastrillado y construcción de taipas en lotes arroceros de Saldaña y Guamo.',
                'precio' => 140000,
                'unidad_precio' => 'por hora',
                'departamento' => 'Tolima',
                'municipio' => 'Saldaña',
                'contacto_telefono' => '3124567890',
                'contacto_whatsapp' => '573124567890',
                'disponible' => true,
            ]);

            Servicio::firstOrCreate([
                'titulo' => 'Servicio de Fumigación y Fertilización con Dron Agrícola DJI T40',
            ], [
                'user_id' => $usuario->id,
                'titulo' => 'Servicio de Fumigación y Fertilización con Dron Agrícola DJI T40',
                'categoria' => 'Fumigación',
                'descripcion' => 'Fumigación de ultra bajo volumen sin pisar el cultivo. Aplicación uniforme de fungicidas, insecticidas y fertilizantes foliares. Cobertura de hasta 25 ha por día.',
                'precio' => 45000,
                'unidad_precio' => 'por hectárea',
                'departamento' => 'Tolima',
                'municipio' => 'El Espinal',
                'contacto_telefono' => '3158901234',
                'contacto_whatsapp' => '573158901234',
                'disponible' => true,
            ]);

            Servicio::firstOrCreate([
                'titulo' => 'Transporte de Arroz Verde en Camión Dobletroque a Molinos',
            ], [
                'user_id' => $usuario->id,
                'titulo' => 'Transporte de Arroz Verde en Camión Dobletroque a Molinos',
                'categoria' => 'Transporte de arroz',
                'descripcion' => 'Camión con carpa arrocera para 18 toneladas. Disponibilidad inmediata para recibo a pie de combinada y entrega en molinos de Saldaña, Espinal e Ibagué.',
                'precio' => 380000,
                'unidad_precio' => 'por viaje',
                'departamento' => 'Tolima',
                'municipio' => 'Saldaña',
                'contacto_telefono' => '3207654321',
                'contacto_whatsapp' => '573207654321',
                'disponible' => true,
            ]);
        }
    }
}
