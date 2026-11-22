
<?php

require_once __DIR__ . '/../Models/Programa.php';

class ProgramaController {

    private $modelo;

    public function __construct() {
        $this->modelo = new Programa();
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

    // VALIDAR DATOS DEL PROGRAMA
    private function validarDatos($datos) {

        // VALIDAR CAMPOS NUMERICOS
        $camposNumericos = [
            'id_categoria',
            'id_modalidad',
            'id_docente',
            'duracion_horas'
        ];

        foreach ($camposNumericos as $campo) {

            if (
                !isset($datos[$campo]) ||
                filter_var($datos[$campo], FILTER_VALIDATE_INT) === false ||
                (int)$datos[$campo] <= 0
            ) {

                $this->responder(400, [
                    "estado" => false,
                    "mensaje" => "El campo {$campo} debe ser un entero mayor que cero"
                ]);

                return false;
            }

            $datos[$campo] = (int)$datos[$campo];
        }

        // VALIDAR NOMBRE
        if (
            !isset($datos['nombre']) ||
            !is_string($datos['nombre'])
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El nombre del programa es obligatorio"
            ]);

            return false;
        }

        $datos['nombre'] = trim($datos['nombre']);

        if ($datos['nombre'] === '') {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El nombre del programa no puede estar vacio"
            ]);

            return false;
        }

        if (mb_strlen($datos['nombre'], 'UTF-8') > 150) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El nombre no puede superar los 150 caracteres"
            ]);

            return false;
        }

        // VALIDAR DESCRIPCION
        if (
            isset($datos['descripcion']) &&
            !is_string($datos['descripcion'])
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "La descripcion debe contener texto"
            ]);

            return false;
        }

        $datos['descripcion'] = isset($datos['descripcion'])
            ? trim($datos['descripcion'])
            : null;

        if ($datos['descripcion'] === '') {
            $datos['descripcion'] = null;
        }

        // VALIDAR BROCHURE
        if (
            isset($datos['brochure']) &&
            !is_string($datos['brochure'])
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El brochure debe contener texto"
            ]);

            return false;
        }

        $datos['brochure'] = isset($datos['brochure'])
            ? trim($datos['brochure'])
            : null;

        if ($datos['brochure'] === '') {
            $datos['brochure'] = null;
        }

        if (
            $datos['brochure'] !== null &&
            mb_strlen($datos['brochure'], 'UTF-8') > 255
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "El nombre del brochure no puede superar los 255 caracteres"
            ]);

            return false;
        }

        // VALIDAR FECHA DE INICIO
        if (
            !isset($datos['fecha_inicio']) ||
            !is_string($datos['fecha_inicio'])
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "La fecha de inicio es obligatoria"
            ]);

            return false;
        }

        $fecha = DateTime::createFromFormat(
            '!Y-m-d',
            $datos['fecha_inicio']
        );

        if (
            !$fecha ||
            $fecha->format('Y-m-d') !== $datos['fecha_inicio']
        ) {

            $this->responder(400, [
                "estado" => false,
                "mensaje" => "La fecha debe tener el formato AAAA-MM-DD"
            ]);

            return false;
        }

        return $datos;
    }

    // 1. LISTAR PROGRAMAS
    public function listar() {

        $datos = $this->modelo->listar();

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Programas encontrados",
            "datos" => $datos
        ]);
    }

    // 2. BUSCAR PROGRAMA POR ID
    public function buscarPorId($id) {

        if (!$this->validarId($id)) {
            return;
        }

        $programa = $this->modelo->buscarPorId($id);

        if (!$programa) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Programa no encontrado"
            ]);

            return;
        }

        $this->responder(200, [
            "estado" => true,
            "datos" => $programa
        ]);
    }

    // 3. CREAR PROGRAMA
    public function crear($datos) {

        $datos = $this->validarDatos($datos);

        if ($datos === false) {
            return;
        }

        $id = $this->modelo->crear($datos);

        $this->responder(201, [
            "estado" => true,
            "mensaje" => "Programa creado correctamente",
            "id_programa" => $id
        ]);
    }

    // 4. ACTUALIZAR PROGRAMA
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
                "mensaje" => "Programa no encontrado"
            ]);

            return;
        }

        $this->modelo->actualizar($id, $datos);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Programa actualizado correctamente",
            "id_programa" => (int)$id
        ]);
    }

    // 5. ELIMINAR PROGRAMA
    public function eliminar($id) {

        if (!$this->validarId($id)) {
            return;
        }

        $existente = $this->modelo->buscarPorId($id);

        if (!$existente) {

            $this->responder(404, [
                "estado" => false,
                "mensaje" => "Programa no encontrado"
            ]);

            return;
        }

        $this->modelo->eliminar($id);

        $this->responder(200, [
            "estado" => true,
            "mensaje" => "Programa eliminado correctamente",
            "id_programa" => (int)$id
        ]);
    }
}
