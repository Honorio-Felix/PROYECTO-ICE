
<?php

require_once __DIR__ . '/../../config/Conexion.php';

class Matricula {

    private $conexion;

    public function __construct() {
        $database = new Conexion();
        $this->conexion = $database->conectar();
    }

    // 1. LISTAR MATRICULAS
    public function listar() {

        $sql = "SELECT
                    m.*,
                    p.nombres_apellidos AS prospecto,
                    pr.nombre AS programa
                FROM matriculas m
                INNER JOIN prospectos p
                    ON m.id_prospecto = p.id_prospecto
                INNER JOIN programas pr
                    ON m.id_programa = pr.id_programa
                ORDER BY m.id_matricula";

        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. BUSCAR MATRICULA POR ID
    public function buscarPorId($id) {

        $sql = "SELECT
                    m.*,
                    p.nombres_apellidos AS prospecto,
                    pr.nombre AS programa
                FROM matriculas m
                INNER JOIN prospectos p
                    ON m.id_prospecto = p.id_prospecto
                INNER JOIN programas pr
                    ON m.id_programa = pr.id_programa
                WHERE m.id_matricula = :id";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // 3. CREAR MATRICULA
    public function crear($datos) {

        $sql = "INSERT INTO matriculas (
                    id_prospecto,
                    id_programa,
                    observaciones
                ) VALUES (
                    :id_prospecto,
                    :id_programa,
                    :observaciones
                )";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_prospecto' => $datos['id_prospecto'],
            ':id_programa' => $datos['id_programa'],
            ':observaciones' => $datos['observaciones'] ?? null
        ]);

        return $this->conexion->lastInsertId();
    }

    // 4. ACTUALIZAR MATRICULA
    public function actualizar($id, $datos) {

        $sql = "UPDATE matriculas SET
                    id_prospecto = :id_prospecto,
                    id_programa = :id_programa,
                    estado = :estado,
                    observaciones = :observaciones
                WHERE id_matricula = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_prospecto' => $datos['id_prospecto'],
            ':id_programa' => $datos['id_programa'],
            ':estado' => $datos['estado'],
            ':observaciones' => $datos['observaciones'] ?? null,
            ':id' => $id
        ]);

        return $consulta->rowCount();
    }

    // 5. ELIMINAR MATRICULA
    public function eliminar($id) {

        $sql = "DELETE FROM matriculas
                WHERE id_matricula = :id";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->rowCount();
    }
}
