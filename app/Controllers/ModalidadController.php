
<?php

require_once __DIR__ . '/../Models/Modalidad.php';

class ModalidadController {

    private $modelo;

    public function __construct() {

        $this->modelo = new Modalidad();
    }

    // 1. LISTAR MODALIDADES
    public function listar() {

        try {

            $modalidades = $this->modelo->listar();

            http_response_code(200);

            echo json_encode([
                "estado" => true,
                "mensaje" => "Modalidades encontradas",
                "datos" => $modalidades
            ]);

        } catch (Throwable $e) {

            error_log($e->getMessage());

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error interno al listar modalidades"
            ]);
        }
    }

    // 2. BUSCAR MODALIDAD POR ID
    public function buscarPorId($id) {

        try {

            if (!is_numeric($id) || $id <= 0) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "ID no valido"
                ]);

                return;
            }

            $modalidad = $this->modelo->buscarPorId($id);

            if (!$modalidad) {

                http_response_code(404);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "Modalidad no encontrada"
                ]);

                return;
            }

            http_response_code(200);

            echo json_encode([
                "estado" => true,
                "datos" => $modalidad
            ]);

        } catch (Throwable $e) {

            error_log($e->getMessage());

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error interno al buscar modalidad"
            ]);
        }
    }

    // 3. CREAR MODALIDAD
    public function crear($datos) {

        try {

            $nombre = $datos['nombre'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';

            if (!is_string($nombre) || !is_string($descripcion)) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "Los campos deben contener texto"
                ]);

                return;
            }

            $nombre = trim($nombre);
            $descripcion = trim($descripcion);

            if ($nombre === '') {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre es obligatorio"
                ]);

                return;
            }

            if (mb_strlen($nombre, 'UTF-8') > 50) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre no puede superar 50 caracteres"
                ]);

                return;
            }

            if (mb_strlen($descripcion, 'UTF-8') > 255) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "La descripcion no puede superar 255 caracteres"
                ]);

                return;
            }

            // Registrar la modalidad y recuperar el ID generado por MySQL
            $id = $this->modelo->registrar($nombre, $descripcion);

            http_response_code(201);

            echo json_encode([
                "estado" => true,
                "mensaje" => "Modalidad creada correctamente",
                "id_modalidad" => $id
            ]);

        } catch (Throwable $e) {

            error_log($e->getMessage());

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error interno al crear modalidad"
            ]);
        }
    }

    // 4. ACTUALIZAR MODALIDAD
    public function actualizar($id, $datos) {

        try {

            if (!is_numeric($id) || $id <= 0) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "ID no valido"
                ]);

                return;
            }

            $nombre = $datos['nombre'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';

            if (!is_string($nombre) || !is_string($descripcion)) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "Los campos deben contener texto"
                ]);

                return;
            }

            $nombre = trim($nombre);
            $descripcion = trim($descripcion);

            if ($nombre === '') {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre es obligatorio"
                ]);

                return;
            }

            if (mb_strlen($nombre, 'UTF-8') > 50) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre no puede superar 50 caracteres"
                ]);

                return;
            }

            if (mb_strlen($descripcion, 'UTF-8') > 255) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "La descripcion no puede superar 255 caracteres"
                ]);

                return;
            }

            $existente = $this->modelo->buscarPorId($id);

            if (!$existente) {

                http_response_code(404);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "Modalidad no encontrada"
                ]);

                return;
            }

            $this->modelo->actualizar($id, $nombre, $descripcion);

            http_response_code(200);

            echo json_encode([
                "estado" => true,
                "mensaje" => "Modalidad actualizada correctamente"
            ]);

        } catch (Throwable $e) {

            error_log($e->getMessage());

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error interno al actualizar modalidad"
            ]);
        }
    }

    // 5. ELIMINAR MODALIDAD
    public function eliminar($id) {

        try {

            if (!is_numeric($id) || $id <= 0) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "ID no valido"
                ]);

                return;
            }

            $existente = $this->modelo->buscarPorId($id);

            if (!$existente) {

                http_response_code(404);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "Modalidad no encontrada"
                ]);

                return;
            }

            $this->modelo->eliminar($id);

            http_response_code(200);

            echo json_encode([
                "estado" => true,
                "mensaje" => "Modalidad eliminada correctamente"
            ]);

        } catch (Throwable $e) {

            error_log($e->getMessage());

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "No se pudo eliminar la modalidad. Puede estar relacionada con programas."
            ]);
        }
    }
}
