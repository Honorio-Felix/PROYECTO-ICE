
<?php

require_once __DIR__ . '/../Models/Solicitud.php';

class SolicitudController {

    private $modelo;

    public function __construct() {
        $this->modelo = new Solicitud();
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

        // VALIDAR MENSAJE
        if (
            !isset($datos['mensaje']) ||
            !is_string($datos['mensaje'])
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El mensaje es obligatorio y debe contener texto"
            ]);

            return false;
        }

        $datos['mensaje'] = trim($datos['mensaje']);

        if ($datos['mensaje'] === '') {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El mensaje no puede estar vacio"
            ]);

            return false;
        }

        // VALIDAR ESTADO AL ACTUALIZAR
        if ($actualizar) {

            $estadosPermitidos = [
                'Pendiente',
                'Atendida'
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

            if (
                !in_array(
                    $datos['estado'],
                    $estadosPermitidos,
                    true
                )
            ) {

                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "El estado debe ser Pendiente o Atendida"
                ]);

                return false;
            }
        }

        return $datos;
    }

    // 1. LISTAR SOLICITUDES
    public function listar() {

        $datos = $this->modelo->listar();

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Solicitudes encontradas",
            "datos" => $datos
        ]);
    }

    // 2. BUSCAR SOLICITUD POR ID
    public function buscarPorId($id) {

        if (!$this->validarId($id)) {
            return;
        }

        $solicitud = $this->modelo->buscarPorId($id);

        if (!$solicitud) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Solicitud no encontrada"
            ]);

            return;
        }

        $this->responder(200, [
            "estado" => true,
            "datos" => $solicitud
        ]);
    }

    // 3. CREAR SOLICITUD
    public function crear($datos) {

        $datos = $this->validarDatos($datos);

        if ($datos === false) {
            return;
        }

        $id = $this->modelo->crear($datos);

        $this->responder(201, [
            "estado" => true,
            "mensaje" => "Solicitud creada correctamente",
            "id_solicitud" => $id
        ]);
    }

    // 4. ACTUALIZAR SOLICITUD
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
                "mensaje" => "Solicitud no encontrada"
            ]);

            return;
        }

        $this->modelo->actualizar($id, $datos);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Solicitud actualizada correctamente",
            "id_solicitud" => (int)$id
        ]);
    }

    // 5. ELIMINAR SOLICITUD
    public function eliminar($id) {

        if (!$this->validarId($id)) {
            return;
        }

        $existente = $this->modelo->buscarPorId($id);

        if (!$existente) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Solicitud no encontrada"
            ]);

            return;
        }

        $this->modelo->eliminar($id);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Solicitud eliminada correctamente",
            "id_solicitud" => (int)$id
        ]);
    }
}

