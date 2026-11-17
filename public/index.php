<?php
require_once __DIR__ . "/../config/bootstrap.php";

$pagina = $_GET["pagina"] ?? "inicio";

require_once __DIR__ . "/../routes/web.php";
