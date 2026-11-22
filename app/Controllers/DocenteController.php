
<?php

require_once __DIR__ . '/../Models/Docente.php';

class DocenteController {

    private $modelo;

    public function __construct() {
        $this->modelo = new Docente();
    }

    // GENERAR RESPUESTA JSON
    private function responder($codigo, $datos) {
        http_response_code($codigo);
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }

    // VALIDAR ID
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

    // VALIDAR DATOS DEL DOCENTE
    private function validarDatos($datos) {

        $campos = [
            'nombres' => 100,
            'apellidos' => 100,
            'especialidad' => 150
        ];

        foreach ($campos as $campo => $limite) {

            if (
                !isset($datos[$campo]) ||
                !is_string($datos[$campo]) ||
                trim($datos[$campo]) === ''
            ) {
                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "El campo {$campo} es obligatorio y debe ser texto"
                ]);

                return false;
            }

            $datos[$campo] = trim($datos[$campo]);

            if (mb_strlen($datos[$campo], 'UTF-8') > $limite) {
                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "El campo {$campo} no puede superar {$limite} caracteres"
                ]);

                return false;
            }
        }

        // Validar perfil profesional opcional
        $datos['perfil_profesional'] =
            $datos['perfil_profesional'] ?? null;

        if ($datos['perfil_profesional'] !== null) {

            if (!is_string($datos['perfil_profesional'])) {
                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "El perfil profesional debe ser texto"
                ]);

                return false;
            }

            $datos['perfil_profesional'] =
                trim($datos['perfil_profesional']);

            if ($datos['perfil_profesional'] === '') {
                $datos['perfil_profesional'] = null;
            }
        }

        return $datos;
    }

    // 1. LISTAR DOCENTES
    public function listar() {

        $datos = $this->modelo->listar();

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Docentes encontrados",
            "datos" => $datos
        ]);
    }

    // 2. BUSCAR DOCENTE POR ID
    public function buscarPorId($id) {

        if (!$this->validarId($id)) return;

        $docente = $this->modelo->buscarPorId((int)$id);

        if (!$docente) {
            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Docente no encontrado"
            ]);

            return;
        }

        $this->responder(200, [
            "estado" => true,
            "datos" => $docente
        ]);
    }

    // 3. CREAR DOCENTE
    public function crear($datos) {

        $datos = $this->validarDatos($datos);

        if ($datos === false) return;

        $id = $this->modelo->crear($datos);

        $this->responder(201, [
            "estado" => true,
            "mensaje" => "Docente creado correctamente",
            "id_docente" => $id
        ]);
    }

    // 4. ACTUALIZAR DOCENTE
    public function actualizar($id, $datos) {

        if (!$this->validarId($id)) return;

        $datos = $this->validarDatos($datos);

        if ($datos === false) return;

        $existente = $this->modelo->buscarPorId((int)$id);

        if (!$existente) {
            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Docente no encontrado"
            ]);

            return;
        }

        $this->modelo->actualizar((int)$id, $datos);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Docente actualizado correctamente"
        ]);
    }

    // 5. ELIMINAR DOCENTE
    public function eliminar($id) {

        if (!$this->validarId($id)) return;

        $existente = $this->modelo->buscarPorId((int)$id);

        if (!$existente) {
            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Docente no encontrado"
            ]);

            return;
        }

        $this->modelo->eliminar((int)$id);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Docente eliminado correctamente"
        ]);
    }
}
