
<?php

require_once __DIR__ . '/../app/Controllers/CategoriaController.php';

header('Content-Type: application/json; charset=utf-8');

$controlador = new CategoriaController();

$metodo = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($metodo) {

    case 'GET':

        if ($id !== null) {

            $controlador->buscarPorId($id);

        } else {

            $controlador->listar();

        }

        break;

    case 'POST':

        $datos = json_decode(file_get_contents("php://input"), true);

        $controlador->crear($datos ?? []);

        break;

    case 'PUT':

        $datos = json_decode(file_get_contents("php://input"), true);

        if ($id === null) {

            http_response_code(400);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Debe proporcionar el ID"
            ]);

            break;
        }

        $controlador->actualizar($id, $datos ?? []);

        break;

    case 'DELETE':

        if ($id === null) {

            http_response_code(400);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Debe proporcionar el ID"
            ]);

            break;
        }

        $controlador->eliminar($id);

        break;

    default:

        http_response_code(405);

        echo json_encode([
            "estado" => false,
            "mensaje" => "Metodo HTTP no permitido"
        ]);

        break;
}
