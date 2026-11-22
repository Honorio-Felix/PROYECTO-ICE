
<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../app/Controllers/ModuloProgramaController.php';

try {

    $controlador = new ModuloProgramaController();

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

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "JSON no valido"
                ], JSON_UNESCAPED_UNICODE);

                break;
            }

            $controlador->crear($datos);

            break;

        case 'PUT':

            $datos = json_decode(file_get_contents("php://input"), true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "JSON no valido"
                ], JSON_UNESCAPED_UNICODE);

                break;
            }

            $controlador->actualizar($id, $datos);

            break;

        case 'DELETE':

            $controlador->eliminar($id);

            break;

        default:

            http_response_code(405);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Metodo HTTP no permitido"
            ], JSON_UNESCAPED_UNICODE);

            break;
    }

} catch (PDOException $e) {

    error_log($e->getMessage());

    // Error de integridad: clave foranea o valor duplicado
    if ($e->getCode() === '23000') {
        http_response_code(400);

        echo json_encode([
            "estado" => false,
            "mensaje" => "No se pudo completar la operacion. Verifique que el programa exista y que el orden no este duplicado dentro del mismo programa"
        ], JSON_UNESCAPED_UNICODE);

    } else {
        http_response_code(500);

        echo json_encode([
            "estado" => false,
            "mensaje" => "Error de base de datos al procesar la operacion"
        ], JSON_UNESCAPED_UNICODE);
    }

} catch (Throwable $e) {

    error_log($e->getMessage());

    http_response_code(500);

    echo json_encode([
        "estado" => false,
        "mensaje" => "Error interno del servidor"
    ], JSON_UNESCAPED_UNICODE);
}
