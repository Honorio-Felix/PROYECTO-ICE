
<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../app/Controllers/ProgramaController.php';

try {

    // CREAR CONTROLADOR
    $controlador = new ProgramaController();

    // OBTENER METODO HTTP E ID
    $metodo = $_SERVER['REQUEST_METHOD'];
    $id = $_GET['id'] ?? null;

    switch ($metodo) {

        // 1. GET: LISTAR O BUSCAR
        case 'GET':

            if ($id !== null) {
                $controlador->buscarPorId($id);
            } else {
                $controlador->listar();
            }

            break;

        // 2. POST: CREAR PROGRAMA
        case 'POST':

            $datos = json_decode(
                file_get_contents("php://input"),
                true
            );

            if (
                json_last_error() !== JSON_ERROR_NONE ||
                !is_array($datos)
            ) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "JSON no valido"
                ], JSON_UNESCAPED_UNICODE);

                break;
            }

            $controlador->crear($datos);

            break;

        // 3. PUT: ACTUALIZAR PROGRAMA
        case 'PUT':

            $datos = json_decode(
                file_get_contents("php://input"),
                true
            );

            if (
                json_last_error() !== JSON_ERROR_NONE ||
                !is_array($datos)
            ) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "JSON no valido"
                ], JSON_UNESCAPED_UNICODE);

                break;
            }

            $controlador->actualizar($id, $datos);

            break;

        // 4. DELETE: ELIMINAR PROGRAMA
        case 'DELETE':

            $controlador->eliminar($id);

            break;

        // 5. METODO NO PERMITIDO
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

    if ($e->getCode() === '23000') {

        http_response_code(400);

        echo json_encode([
            "estado" => false,
            "mensaje" => "No se puede completar la operacion. Verifique que la categoria, modalidad y docente existan, que el nombre del programa no este duplicado y que no tenga registros relacionados"
        ], JSON_UNESCAPED_UNICODE);

    } else {

        http_response_code(500);

        echo json_encode([
            "estado" => false,
            "mensaje" => "Error interno de base de datos"
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

