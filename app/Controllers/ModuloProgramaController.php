
<?php

require_once __DIR__ . '/../Models/ModuloPrograma.php';

class ModuloProgramaController {

    private $modelo;

    public function __construct() {
        $this->modelo = new ModuloPrograma();
    }

    // GENERAR RESPUESTA JSON
    private function responder($codigo, $datos) {
        http_response_code($codigo);
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }

    // VALIDAR ID DEL MODULO
    private function validarId($id) {

        if (
            filter_var($id, FILTER_VALIDATE_INT) === false ||
            (int)$id <= 0
        ) {
            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El ID debe ser un entero mayor que cero"
            ]);

            return false;
        }

        return true;
    }

    // VALIDAR DATOS DEL MODULO
    private function validarDatos($datos) {

        // Validar ID del programa
        if (
            !isset($datos['id_programa']) ||
            filter_var($datos['id_programa'], FILTER_VALIDATE_INT) === false ||
            (int)$datos['id_programa'] <= 0
        ) {
            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El ID del programa debe ser un entero mayor que cero"
            ]);

            return false;
        }

        $datos['id_programa'] = (int)$datos['id_programa'];

        // Validar nombre
        if (
            !isset($datos['nombre']) ||
            !is_string($datos['nombre']) ||
            trim($datos['nombre']) === ''
        ) {
            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El nombre del modulo es obligatorio"
            ]);

            return false;
        }

        $datos['nombre'] = trim($datos['nombre']);

        if (mb_strlen($datos['nombre'], 'UTF-8') > 150) {
            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El nombre no puede superar 150 caracteres"
            ]);

            return false;
        }

        // Validar orden
        if (
            !isset($datos['orden']) ||
            filter_var($datos['orden'], FILTER_VALIDATE_INT) === false ||
            (int)$datos['orden'] <= 0
        ) {
            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El orden debe ser un entero mayor que cero"
            ]);

            return false;
        }

        $datos['orden'] = (int)$datos['orden'];

        // Validar descripcion opcional
        $datos['descripcion'] = $datos['descripcion'] ?? null;

        if ($datos['descripcion'] !== null) {

            if (!is_string($datos['descripcion'])) {
                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "La descripcion debe ser texto"
                ]);

                return false;
            }

            $datos['descripcion'] = trim($datos['descripcion']);

            if ($datos['descripcion'] === '') {
                $datos['descripcion'] = null;
            }
        }

        // Validar horas opcionales
        $datos['horas'] = $datos['horas'] ?? null;

        if ($datos['horas'] !== null) {

            if (
                filter_var($datos['horas'], FILTER_VALIDATE_INT) === false ||
                (int)$datos['horas'] <= 0
            ) {
                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "Las horas deben ser un entero mayor que cero"
                ]);

                return false;
            }

            $datos['horas'] = (int)$datos['horas'];
        }

        return $datos;
    }

    // 1. LISTAR MODULOS
    public function listar() {

        $datos = $this->modelo->listar();

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Modulos encontrados",
            "datos" => $datos
        ]);
    }

    // 2. BUSCAR MODULO POR ID
    public function buscarPorId($id) {

        if (!$this->validarId($id)) return;

        $modulo = $this->modelo->buscarPorId($id);

        if (!$modulo) {
            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Modulo no encontrado"
            ]);

            return;
        }

        $this->responder(200, [
            "estado" => true,
            "datos" => $modulo
        ]);
    }

    // 3. CREAR MODULO
    public function crear($datos) {

        $datos = $this->validarDatos($datos);

        if ($datos === false) return;

        $id = $this->modelo->crear($datos);

        $this->responder(201, [
            "estado" => true,
            "mensaje" => "Modulo creado correctamente",
            "id_modulo" => $id
        ]);
    }

    // 4. ACTUALIZAR MODULO
    public function actualizar($id, $datos) {

        if (!$this->validarId($id)) return;

        $datos = $this->validarDatos($datos);

        if ($datos === false) return;

        $existente = $this->modelo->buscarPorId($id);

        if (!$existente) {
            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Modulo no encontrado"
            ]);

            return;
        }

        $this->modelo->actualizar($id, $datos);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Modulo actualizado correctamente"
        ]);
    }

    // 5. ELIMINAR MODULO
    public function eliminar($id) {

        if (!$this->validarId($id)) return;

        $existente = $this->modelo->buscarPorId($id);

        if (!$existente) {
            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Modulo no encontrado"
            ]);

            return;
        }

        $this->modelo->eliminar($id);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Modulo eliminado correctamente"
        ]);
    }
}

