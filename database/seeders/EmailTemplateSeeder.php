<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;
use Symfony\Component\Mime\Email;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailTemplate::create([
            'key' => 'notice_published',
            'name' => 'Noticias',
            'subject' => '¡Nueva noticia publicada: {{ notice_title }}!',
            'body' => '<p><strong>Hola {{ user_name }}, </strong></p><p><br></p><p> Se ha publicado: </p><p><strong>{{ notice_title }}</strong>. </p><p><br></p><p> </p><p><a href="{{ notice_url }}">Leer más</a></p><p> Gracias por utilizar nuestra plataforma. </p>',
            'available_variables' => [
                '{{ user_name }}',
                '{{ notice_title }}',
                '{{ notice_url }}'
            ],
            'footer' => '<p>Gracias,</p><p>PIVITMor</p>'
        ]);

        EmailTemplate::create([
            'key' => 'privacity_advice_deny',
            'name' => 'Rechazo de políticas de privacidad',
            'subject' => 'Políticas de privacidad rechazadas',
            'body' => '<p><strong>Hola {{ user_name }}, </strong></p><p> Has rechazado las políticas de privacidad de nuestra plataforma. </p><p> Para continuar utilizando nuestros servicios, es necesario que aceptes las políticas de privacidad. </p><p> Si deseas solicitar la baja de tu cuenta o tienes alguna duda, por favor contacta con soporte. </p><p> Contacto: soporte@ejemplo.com</p><p> Gracias por utilizar nuestra plataforma. </p>',
            'available_variables' => [
                '{{ user_name }}'
            ],
            'footer' => '<p>Gracias,</p><p>PIVITMor</p>'
        ]);

        EmailTemplate::create([
            'key' => 'match_response',
            'name' => 'Respuesta a vinculación',
            'subject' => 'Has recibido una respuesta del {{ actor }}',
            'body' => '<p><strong>Hola {{ user_name }}, </strong></p><p> El {{ actor }} ha respondido a la vinculación que le enviaste. Puedes revisar los detalles en el siguiente enlace. </p><p><a href="{{ link }}">Ver vinculación</a></p><p> Gracias por utilizar nuestra plataforma. </p>',
            'available_variables' => [
                '{{ user_name }}',
                '{{ actor }}',
                '{{ link }}',
                '{{ label }}',
                '{{ title }}'
            ],
            'footer' => '<p>Gracias,</p><p>PIVITMor</p>'
        ]);

        EmailTemplate::create([
            'key' => 'match',
            'name' => 'Notificación de vinculación',
            'subject' => '{{ label }} emparejada con éxito',
            'body' => '<p><strong>Hola {{ user_name }}, </strong></p><p> Tu {{ label }} ha sido emparejada exitosamente y creemos puede ser de tu interés. </p><p> Puedes revisarla todas tus vinculaciones en el siguiente enlace: </p><p><a href="{{ link }}">Ver vinculación</a></p><p> Gracias por utilizar nuestra plataforma. </p>',
            'available_variables' => [
                '{{ title }}',
                '{{ user_name }}',
                '{{ label }}',
                '{{ link }}'
            ],
            'footer' => '<p>Gracias,</p><p>PIVITMor</p>'
        ]);

        EmailTemplate::create([
            'key' => 'evaluation',
            'name' => 'Notificación de evaluación',
            'subject' => 'Tu {{ label }} ha sido evaluada',
            'body' => '<p><strong>Hola {{ user_name }}, </strong></p><p> La {{ label }} que enviaste ha sido revisada y evaluada por el administrador. </p><p> Puedes consultarla desde el siguiente enlace: </p><p><a href="{{ link }}">Ver evaluación</a></p><p> Gracias por utilizar nuestra plataforma. </p>',
            'available_variables' => [
                '{{ title }}',
                '{{ user_name }}',
                '{{ label }}',
                '{{ link }}'
            ],
            'footer' => '<p>Gracias,</p><p>PIVITMor</p>'
        ]);

        EmailTemplate::create([
            'key' => 'academic_credentials',
            'name' => 'Bienvenida y Credenciales de Académico',
            'subject' => 'Bienvenido al Sistema - Credenciales de Acceso',
            'body' => '<p>Hola, {{ user_name }}</p><p>Tu cuenta de académico ha sido creada exitosamente.</p><p>Tus credenciales de acceso son:</p><ul><li><strong>Correo:</strong> {{ email }}</li><li><strong>Contraseña temporal:</strong> {{ password }}</li></ul><p><a href="{{ link }}">Iniciar Sesión</a></p><p>Te recomendamos cambiar tu contraseña inmediatamente después de ingresar.</p><p>Saludos,<br>El Equipo de PIVITMor</p>',
            'available_variables' => [
                '{{ user_name }}',
                '{{ email }}',
                '{{ password }}',
                '{{ link }}'
            ],
            'footer' => '<p>Gracias,</p><p>PIVITMor</p>'
        ]);

        EmailTemplate::create([
            'key' => 'backup_success',
            'name' => 'Respaldo Exitoso',
            'subject' => 'Respaldo de Base de Datos Completado',
            'body' => '<p><strong>Hola {{ user_name }}, </strong></p><p> El respaldo automático de la base de datos se ha completado sin errores. </p><p>Detalles del respaldo:</p><ul><li><strong>Archivo:</strong> {{ filename }}</li><li><strong>Fecha:</strong> {{ date }}</li><li><strong>Ubicación:</strong> {{ location }}</li></ul><p> El archivo ha sido almacenado de forma segura. </p><p> Gracias por utilizar nuestra plataforma. </p>',
            'available_variables' => [
                '{{ user_name }}',
                '{{ filename }}',
                '{{ date }}',
                '{{ location }}'
            ],
            'footer' => '<p>Gracias,</p><p>PIVITMor</p>'
        ]);

        EmailTemplate::create([
            'key' => 'backup_failure',
            'name' => 'Fallo en Respaldo',
            'subject' => 'Error Crítico en Respaldo de Base de Datos',
            'body' => '<p><strong>Hola {{ user_name }}, </strong></p><p> <strong>Acción Requerida:</strong> El respaldo automático ha fallado. </p><p>Detalles del intento:</p><ul><li><strong>Archivo:</strong> {{ filename }}</li><li><strong>Fecha:</strong> {{ date }}</li></ul><p><strong>Error reportado:</strong><br> {{ error }} </p><p> Por favor contacte al equipo de soporte técnico inmediatamente. </p>',
            'available_variables' => [
                '{{ user_name }}',
                '{{ filename }}',
                '{{ date }}',
                '{{ error }}'
            ],
            'footer' => '<p>Gracias,</p><p>PIVITMor</p>'
        ]);
    }
}
