# Kevin Barber Shop - Sistema de citas

## Descripción
Sitio web para una barbería donde los clientes pueden consultar los horarios
disponibles y reservar su cita. Las citas se guardan en una base de datos y se
administran desde una página con CRUD completo (crear, leer, editar y eliminar).
Además, cada cita se registra en Google Calendar.

## Tecnologías utilizadas
- HTML5 (etiquetas semánticas)
- CSS y Bootstrap 5.3
- JavaScript (validación de formularios, manipulación del DOM, fetch)
- PHP 8 con PDO
- SQLite (archivo barberia.db)
- Google Apps Script y Google Calendar
- Wampserver (Apache + PHP)

## Páginas del sitio
| Página | Descripción |
|---|---|
| index.html | Inicio: servicios, galería y contacto |
| agendar.html | Formulario para reservar una cita |
| citas.html | Tabla de citas con botones de editar y eliminar |

## Funcionalidad CRUD
- **Crear:** formulario en agendar.html (guardar_cita.php)
- **Leer:** tabla en citas.html (listar_cita.php)
- **Actualizar:** ventana modal de edición (editar_cita.php)
- **Eliminar:** botón con confirmación (eliminar_cita.php)

## Instrucciones de ejecución
1. Instalar Wampserver y ponerlo en verde.
2. Copiar la carpeta del proyecto dentro de `C:\wamp64\www\`.
3. Verificar que la extensión `pdo_sqlite` de PHP esté activada.
4. Si no existe el archivo `barberia.db`, abrir una vez
   `http://localhost/barberia/crear_bd.php` para crearlo.
5. Abrir `http://localhost/barberia/index.html` en el navegador.

## Google Calendar
La disponibilidad y el registro en el calendario funcionan con Google Apps Script
(código en `apps_script.gs`). Para usar tu propio calendario:
1. Crear un proyecto en script.google.com y pegar ese código.
2. Implementarlo como Aplicación web.
3. Copiar la URL en la constante `URL_SCRIPT` de `agendar.html`.

## Limitaciones conocidas
- Editar o eliminar una cita en la base de datos no la modifica en Google Calendar.
- La página citas.html no tiene inicio de sesión.

## Autor
[Antonio Cisneros] - Proyecto Final de Programación Web