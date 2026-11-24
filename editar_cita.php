<?php
// Respondemos en formato JSON
header("Content-Type: application/json; charset=utf-8");

// 1. Nos conectamos a la base de datos SQLite
$bd = new PDO("sqlite:" . __DIR__ . "/barberia.db");

// 2. Leemos los datos que manda la pagina
$datos = json_decode(file_get_contents("php://input"), true);

// Horas permitidas (de 10:00 a 18:00)
$horasPermitidas = ["10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00"];

// Si la hora no esta en la lista, rechazamos la edicion
if (!in_array($datos["hora"], $horasPermitidas)) {
    echo json_encode(["ok" => false, "mensaje" => "Hora no permitida. Elige entre 10:00 y 18:00."]);
    exit;
}

try {
    // 3. Preparamos el UPDATE (los ? se llenan despues)
    $consulta = $bd->prepare(
        "UPDATE citas
         SET nombre = ?, servicio = ?, whatsapp = ?, correo = ?, fecha = ?, hora = ?
         WHERE id = ?"
    );

    // 4. Ejecutamos con los 7 datos en el mismo orden de los ?
    $consulta->execute([
        $datos["nombre"],
        $datos["servicio"],
        $datos["whatsapp"],
        $datos["correo"],
        $datos["fecha"],
        $datos["hora"],
        $datos["id"]
    ]);

    echo json_encode(["ok" => true, "mensaje" => "Cita actualizada"]);

} catch (Exception $error) {
    // Si falla (por ejemplo, otra cita ya tiene esa fecha y hora), avisamos
    echo json_encode(["ok" => false, "mensaje" => "No se pudo actualizar. Puede que esa fecha y hora ya estén ocupadas."]);
}