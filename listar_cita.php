<?php
// Le decimos al navegador que respondemos en formato JSON
header("Content-Type: application/json; charset=utf-8");

// 1. Nos conectamos a la base de datos SQLite
$bd = new PDO("sqlite:" . __DIR__ . "/barberia.db");

// 2. Pedimos todas las citas ordenadas por fecha y hora
$consulta = $bd->query("SELECT * FROM citas ORDER BY fecha, hora");

// 3. fetchAll junta todas las filas en una lista
$citas = $consulta->fetchAll(PDO::FETCH_ASSOC);

// 4. Convertimos la lista a JSON y la enviamos
echo json_encode($citas);