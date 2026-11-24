<?php
// Abrimos (o creamos) el archivo de la base de datos
$bd = new PDO("sqlite:" . __DIR__ . "/barberia.db");

// Creamos la tabla de citas si todavia no existe
$bd->exec("
  CREATE TABLE IF NOT EXISTS citas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    whatsapp TEXT NOT NULL,
    correo TEXT NOT NULL,
    servicio TEXT NOT NULL,
    fecha TEXT NOT NULL,
    hora TEXT NOT NULL,
    creado TEXT DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (fecha, hora)
  )
");

echo "Base de datos y tabla creadas";