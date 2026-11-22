
<?php

// Configuración de la respuesta
header("Content-Type: application/json; charset=UTF-8");

// Información principal de la API
$respuesta = [
    "proyecto" => "API ICE - Instituto de Comercio Exterior",
    "version" => "1.0.0",
    "estado" => "Activo",
    "mensaje" => "API funcionando correctamente",

    // Módulos disponibles
    "modulos" => [
        "categorias" => "../routers/categorias.php",
        "modalidades" => "../routers/modalidades.php",
        "docentes" => "../routers/docentes.php",
        "programas" => "../routers/programas.php",
        "modulos_programa" => "../routers/modulos_programa.php",
        "prospectos" => "../routers/prospectos.php",
        "solicitudes" => "../routers/solicitudes.php",
        "matriculas" => "../routers/matriculas.php"
    ]
];

// Enviar respuesta JSON
http_response_code(200);
echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
