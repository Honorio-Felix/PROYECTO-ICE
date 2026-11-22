
<?php

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../app/Controllers/ModalidadController.php';

$controlador = new ModalidadController();

$metodo = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

// Recibir los datos enviados en formato JSON
$datos = json_decode(file_get_contents("php://input"), true);


// CONTROL DE SOLICITUDES HTTP

switch ($metodo) {

    // 1. GET: LISTAR O BUSCAR
    case 'GET':

        if ($id !== null) {

            $controlador->buscarPorId($id);

        } else {

            $controlador->listar();

        }

        break;


    // 2. POST: CREAR
    case 'POST':

        $controlador->crear($datos ?? []);

        break;


    // 3. PUT: ACTUALIZAR
    case 'PUT':

        if ($id === null) {

            http_response_code(400);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Debe proporcionar el ID de la modalidad"
            ]);

            break;
        }

        $controlador->actualizar($id, $datos ?? []);

        break;


    // 4. DELETE: ELIMINAR
    case 'DELETE':

        if ($id === null) {

            http_response_code(400);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Debe proporcionar el ID de la modalidad"
            ]);

            break;
        }

        $controlador->eliminar($id);

        break;


    // 5. MÉTODO NO PERMITIDO
    default:

        http_response_code(405);

        echo json_encode([
            "estado" => false,
            "mensaje" => "Metodo HTTP no permitido"
        ]);

        break;
}
