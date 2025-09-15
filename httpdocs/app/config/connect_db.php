<?php

$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
if (!$link) {
   echo "Hubo un problema con la conexión de la base de datos";
}
mysqli_set_charset($link, "utf8mb4");
