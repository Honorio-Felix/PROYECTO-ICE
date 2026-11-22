
<?php

require_once __DIR__ . '/../../config/Conexion.php';

class Solicitud {

    private $conexion;

    public function __construct() {
        $database = new Conexion();
        $this->conexion = $database->conectar();
    }

    // 1. LISTAR SOLICITUDES
    public function listar() {

        $sql = "SELECT
                    s.*,
                    p.nombres_apellidos AS prospecto,
                    pr.nombre AS programa
                FROM solicitudes s
                INNER JOIN prospectos p
                    ON s.id_prospecto = p.id_prospecto
                INNER JOIN programas pr
                    ON s.id_programa = pr.id_programa
                ORDER BY s.id_solicitud";

        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. BUSCAR SOLICITUD POR ID
    public function buscarPorId($id) {

        $sql = "SELECT
                    s.*,
                    p.nombres_apellidos AS prospecto,
                    pr.nombre AS programa
                FROM solicitudes s
                INNER JOIN prospectos p
                    ON s.id_prospecto = p.id_prospecto
                INNER JOIN programas pr
                    ON s.id_programa = pr.id_programa
                WHERE s.id_solicitud = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // 3. CREAR SOLICITUD
    public function crear($datos) {

        $sql = "INSERT INTO solicitudes (
                    id_prospecto,
                    id_programa,
                    mensaje
                ) VALUES (
                    :id_prospecto,
                    :id_programa,
                    :mensaje
                )";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_prospecto' => $datos['id_prospecto'],
            ':id_programa' => $datos['id_programa'],
            ':mensaje' => $datos['mensaje']
        ]);

        return $this->conexion->lastInsertId();
    }

    // 4. ACTUALIZAR SOLICITUD
    public function actualizar($id, $datos) {

        $sql = "UPDATE solicitudes SET
                    id_prospecto = :id_prospecto,
                    id_programa = :id_programa,
                    mensaje = :mensaje,
                    estado = :estado
                WHERE id_solicitud = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_prospecto' => $datos['id_prospecto'],
            ':id_programa' => $datos['id_programa'],
            ':mensaje' => $datos['mensaje'],
            ':estado' => $datos['estado'],
            ':id' => $id
        ]);

        return $consulta->rowCount();
    }

    // 5. ELIMINAR SOLICITUD
    public function eliminar($id) {

        $sql = "DELETE FROM solicitudes
                WHERE id_solicitud = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->rowCount();
    }
}

