<?php
// 1. Nos conectamos a la base de datos SQLite (el archivo barberia.db)
$bd = new PDO("sqlite:" . __DIR__ . "/barberia.db");

// 2. Leemos los datos que manda la pagina
$datos = json_decode(file_get_contents("php://input"), true);

// 3. Preparamos el INSERT (los ? se llenan despues)
$consulta = $bd->prepare(
    "INSERT INTO citas (nombre, whatsapp, correo, servicio, fecha, hora)
     VALUES (?, ?, ?, ?, ?, ?)"
);

// 4. Ejecutamos mandando los 6 datos en el mismo orden de los ?
$consulta->execute([
    $datos["nombre"],
    $datos["whatsapp"],
    $datos["correo"],
    $datos["servicio"],
    $datos["fecha"],
    $datos["hora"]
]);

// 5. Avisamos que se guardo
echo "Cita guardada";