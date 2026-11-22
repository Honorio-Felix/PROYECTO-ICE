
<?php

require_once __DIR__ . '/../Models/Prospecto.php';

class ProspectoController {

    private $modelo;

    public function __construct() {
        $this->modelo = new Prospecto();
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

    // VALIDAR DATOS DEL PROSPECTO
    private function validarDatos($datos) {

        $campos = [
            'nombres_apellidos',
            'correo',
            'telefono',
            'perfil'
        ];

        // VALIDAR CAMPOS OBLIGATORIOS
        foreach ($campos as $campo) {

            if (
                !isset($datos[$campo]) ||
                !is_string($datos[$campo]) ||
                trim($datos[$campo]) === ''
            ) {

                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "El campo {$campo} es obligatorio y debe contener texto"
                ]);

                return false;
            }

            $datos[$campo] = trim($datos[$campo]);
        }

        // VALIDAR LONGITUD DEL NOMBRE
        if (
            mb_strlen($datos['nombres_apellidos'], 'UTF-8') > 150
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "Los nombres y apellidos no pueden superar 150 caracteres"
            ]);

            return false;
        }

        // VALIDAR CORREO
        if (
            mb_strlen($datos['correo'], 'UTF-8') > 120 ||
            !filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El correo no tiene un formato valido o supera 120 caracteres"
            ]);

            return false;
        }

        // VALIDAR TELEFONO
        if (
            mb_strlen($datos['telefono'], 'UTF-8') > 20
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El telefono no puede superar 20 caracteres"
            ]);

            return false;
        }

        // VALIDAR PERFIL
        if (
            mb_strlen($datos['perfil'], 'UTF-8') > 50
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El perfil no puede superar 50 caracteres"
            ]);

            return false;
        }

        return $datos;
    }

    // 1. LISTAR PROSPECTOS
    public function listar() {

        $datos = $this->modelo->listar();

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Prospectos encontrados",
            "datos" => $datos
        ]);
    }

    // 2. BUSCAR PROSPECTO POR ID
    public function buscarPorId($id) {

        if (!$this->validarId($id)) {
            return;
        }

        $prospecto = $this->modelo->buscarPorId($id);

        if (!$prospecto) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Prospecto no encontrado"
            ]);

            return;
        }

        $this->responder(200, [
            "estado" => true,
            "datos" => $prospecto
        ]);
    }

    // 3. CREAR PROSPECTO
    public function crear($datos) {

        $datos = $this->validarDatos($datos);

        if ($datos === false) {
            return;
        }

        $id = $this->modelo->crear($datos);

        $this->responder(201, [
            "estado" => true,
            "mensaje" => "Prospecto creado correctamente",
            "id_prospecto" => $id
        ]);
    }

    // 4. ACTUALIZAR PROSPECTO
    public function actualizar($id, $datos) {

        if (!$this->validarId($id)) {
            return;
        }

        $datos = $this->validarDatos($datos);

        if ($datos === false) {
            return;
        }

        $existente = $this->modelo->buscarPorId($id);

        if (!$existente) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Prospecto no encontrado"
            ]);

            return;
        }

        $this->modelo->actualizar($id, $datos);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Prospecto actualizado correctamente",
            "id_prospecto" => (int)$id
        ]);
    }

    // 5. ELIMINAR PROSPECTO
    public function eliminar($id) {

        if (!$this->validarId($id)) {
            return;
        }

        $existente = $this->modelo->buscarPorId($id);

        if (!$existente) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Prospecto no encontrado"
            ]);

            return;
        }

        $this->modelo->eliminar($id);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Prospecto eliminado correctamente",
            "id_prospecto" => (int)$id
        ]);
    }
}

