
<?php

require_once __DIR__ . '/../Models/Categoria.php';

class CategoriaController {

    private $modelo;

    public function __construct() {

        $this->modelo = new Categoria();
    }

    // 1. LISTAR CATEGORIAS
    public function listar() {

        try {

            $categorias = $this->modelo->listar();

            http_response_code(200);

            echo json_encode([
                "estado" => true,
                "mensaje" => "Categorias encontradas",
                "datos" => $categorias
            ]);

        } catch (Throwable $e) {

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error al listar categorias"
            ]);
        }
    }

    // 2. BUSCAR CATEGORIA POR ID
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

            $categoria = $this->modelo->buscarPorId($id);

            if (!$categoria) {

                http_response_code(404);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "Categoria no encontrada"
                ]);

                return;
            }

            http_response_code(200);

            echo json_encode([
                "estado" => true,
                "datos" => $categoria
            ]);

        } catch (Throwable $e) {

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error al buscar categoria"
            ]);
        }
    }

    // 3. CREAR CATEGORIA
    public function crear($datos) {

        try {

            $nombre = $datos['nombre'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';

            // Validar que nombre sea texto
            if (!is_string($nombre) || !is_string($descripcion)) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "Los campos deben contener texto"
                ]);

                return;
            }

            // Eliminar espacios innecesarios
            $nombre = trim($nombre);
            $descripcion = trim($descripcion);

            // Validar nombre obligatorio
            if ($nombre === '') {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre es obligatorio"
                ]);

                return;
            }

            // Validar longitud del nombre
            if (mb_strlen($nombre, 'UTF-8') > 100) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre no puede superar 100 caracteres"
                ]);

                return;
            }

            // Validar longitud de la descripcion
            if (mb_strlen($descripcion, 'UTF-8') > 255) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "La descripcion no puede superar 255 caracteres"
                ]);

                return;
            }

            $id = $this->modelo->crear($nombre, $descripcion);

            http_response_code(201);

            echo json_encode([
                "estado" => true,
                "mensaje" => "Categoria creada correctamente",
                "id_categoria" => $id
            ]);

        } catch (PDOException $e) {

            if ($e->getCode() == '23000') {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre de la categoria ya existe"
                ]);

                return;
            }

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error al crear categoria"
            ]);

        } catch (Throwable $e) {

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error interno del servidor"
            ]);
        }
    }

    // 4. ACTUALIZAR CATEGORIA
    public function actualizar($id, $datos) {

        try {

            if (filter_var($id, FILTER_VALIDATE_INT) === false || $id <= 0) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "ID no valido"
                ]);

                return;
            }


            $nombre = $datos['nombre'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';

            // Validar tipos de datos
            if (!is_string($nombre) || !is_string($descripcion)) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "Los campos deben contener texto"
                ]);

                return;
            }

            // Limpiar espacios
            $nombre = trim($nombre);
            $descripcion = trim($descripcion);

            // Validar nombre obligatorio
            if ($nombre === '') {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre es obligatorio"
                ]);

                return;
            }

            // Validar longitud del nombre
            if (mb_strlen($nombre, 'UTF-8') > 100) {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre no puede superar 100 caracteres"
                ]);

                return;
            }

            // Validar longitud de descripcion
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
                    "mensaje" => "Categoria no encontrada"
                ]);

                return;
            }

            $this->modelo->actualizar($id, $nombre, $descripcion);

            http_response_code(200);

            echo json_encode([
                "estado" => true,
                "mensaje" => "Categoria actualizada correctamente"
            ]);

        } catch (PDOException $e) {

            if ($e->getCode() == '23000') {

                http_response_code(400);

                echo json_encode([
                    "estado" => false,
                    "mensaje" => "El nombre de la categoria ya existe"
                ]);

                return;
            }

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error al actualizar categoria"
            ]);

        } catch (Throwable $e) {

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error interno del servidor"
            ]);
        }
    }

    // 5. ELIMINAR CATEGORIA
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
                    "mensaje" => "Categoria no encontrada"
                ]);

                return;
            }

            $this->modelo->eliminar($id);

            http_response_code(200);

            echo json_encode([
                "estado" => true,
                "mensaje" => "Categoria eliminada correctamente"
            ]);

        } catch (Throwable $e) {

            http_response_code(500);

            echo json_encode([
                "estado" => false,
                "mensaje" => "Error al eliminar categoria"
            ]);
        }
    }

}
