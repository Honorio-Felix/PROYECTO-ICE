
<?php

require_once __DIR__ . '/../Models/Matricula.php';

class MatriculaController {

    private $modelo;

    public function __construct() {
        $this->modelo = new Matricula();
    }

    // RESPUESTA JSON
    private function responder($codigo, $datos) {

        http_response_code($codigo);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $datos,
            JSON_UNESCAPED_UNICODE
        );
    }

    // VALIDAR ID
    private function validarId($id) {

        if (
            filter_var($id, FILTER_VALIDATE_INT) === false ||
            (int)$id <= 0
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "ID no valido"
            ]);

            return false;
        }

        return true;
    }

    // VALIDAR DATOS
    private function validarDatos($datos, $actualizar = false) {

        // VALIDAR PROSPECTO
        if (
            !isset($datos['id_prospecto']) ||
            filter_var($datos['id_prospecto'], FILTER_VALIDATE_INT) === false ||
            (int)$datos['id_prospecto'] <= 0
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El ID del prospecto debe ser un entero mayor que cero"
            ]);

            return false;
        }

        // VALIDAR PROGRAMA
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

        $datos['id_prospecto'] = (int)$datos['id_prospecto'];
        $datos['id_programa'] = (int)$datos['id_programa'];

        // VALIDAR OBSERVACIONES
        if (
            isset($datos['observaciones']) &&
            !is_string($datos['observaciones'])
        ) {
            $this->responder(400, [
                "estado" => false,
                "mensaje" => "Las observaciones deben contener texto"
            ]);

            return false;
        }

        $datos['observaciones'] = isset($datos['observaciones'])
            ? trim($datos['observaciones'])
            : null;

        if ($datos['observaciones'] === '') {
            $datos['observaciones'] = null;
        }

        // VALIDAR ESTADO AL ACTUALIZAR
        if ($actualizar) {

            $estadosPermitidos = [
                'Registrada',
                'Pendiente'
            ];

            if (
                !isset($datos['estado']) ||
                !is_string($datos['estado'])
            ) {

                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "El estado es obligatorio"
                ]);

                return false;
            }

            $datos['estado'] = trim($datos['estado']);

            if (!in_array($datos['estado'], $estadosPermitidos, true)) {

                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "Estado no permitido. Use Registrada o Pendiente"
                ]);

                return false;
            }
        }

        return $datos;
    }

    // 1. LISTAR MATRICULAS
    public function listar() {

        $datos = $this->modelo->listar();

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Matriculas encontradas",
            "datos" => $datos
        ]);
    }

    // 2. BUSCAR MATRICULA POR ID
    public function buscarPorId($id) {

        if (!$this->validarId($id)) {
            return;
        }

        $matricula = $this->modelo->buscarPorId($id);

        if (!$matricula) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Matricula no encontrada"
            ]);

            return;
        }

        $this->responder(200, [
            "estado" => true,
            "datos" => $matricula
        ]);
    }

    // 3. CREAR MATRICULA
    public function crear($datos) {

        $datos = $this->validarDatos($datos);

        if ($datos === false) {
            return;
        }

        $id = $this->modelo->crear($datos);

        $this->responder(201, [
            "estado" => true,
            "mensaje" => "Matricula creada correctamente",
            "id_matricula" => $id
        ]);
    }

    // 4. ACTUALIZAR MATRICULA
    public function actualizar($id, $datos) {

        if (!$this->validarId($id)) {
            return;
        }

        $datos = $this->validarDatos($datos, true);

        if ($datos === false) {
            return;
        }

        $existente = $this->modelo->buscarPorId($id);

        if (!$existente) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Matricula no encontrada"
            ]);

            return;
        }

        $this->modelo->actualizar($id, $datos);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Matricula actualizada correctamente",
            "id_matricula" => (int)$id
        ]);
    }

    // 5. ELIMINAR MATRICULA
    public function eliminar($id) {

        if (!$this->validarId($id)) {
            return;
        }

        $existente = $this->modelo->buscarPorId($id);

        if (!$existente) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Matricula no encontrada"
            ]);

            return;
        }

        $this->modelo->eliminar($id);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Matricula eliminada correctamente",
            "id_matricula" => (int)$id
        ]);
    }
}
