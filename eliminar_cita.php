<?php
// Respondemos en formato JSON
header("Content-Type: application/json; charset=utf-8");

// 1. Nos conectamos a la base de datos SQLite
$bd = new PDO("sqlite:" . __DIR__ . "/barberia.db");

// 2. Leemos el id de la cita que manda la pagina
$datos = json_decode(file_get_contents("php://input"), true);

// 3. Preparamos el DELETE (el ? se llena despues)
$consulta = $bd->prepare("DELETE FROM citas WHERE id = ?");

// 4. Ejecutamos con el id recibido
$consulta->execute([$datos["id"]]);

// 5. Avisamos que se elimino
echo json_encode(["ok" => true, "mensaje" => "Cita eliminada"]);