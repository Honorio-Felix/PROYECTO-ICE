
<?php

require_once __DIR__ . '/../../config/Conexion.php';

class ModuloPrograma {

    private $conexion;

    public function __construct() {
        $database = new Conexion();
        $this->conexion = $database->conectar();
    }

    // 1. LISTAR TODOS LOS MODULOS
    public function listar() {

        $sql = "SELECT
                    mp.*,
                    p.nombre AS programa
                FROM modulos_programa mp
                INNER JOIN programas p
                    ON mp.id_programa = p.id_programa
                ORDER BY mp.id_programa, mp.orden";

        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. BUSCAR MODULO POR ID
    public function buscarPorId($id) {

        $sql = "SELECT
                    mp.*,
                    p.nombre AS programa
                FROM modulos_programa mp
                INNER JOIN programas p
                    ON mp.id_programa = p.id_programa
                WHERE mp.id_modulo = :id";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // 3. CREAR MODULO
    public function crear($datos) {

        $sql = "INSERT INTO modulos_programa (
                    id_programa,
                    nombre,
                    descripcion,
                    orden,
                    horas
                ) VALUES (
                    :id_programa,
                    :nombre,
                    :descripcion,
                    :orden,
                    :horas
                )";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_programa' => $datos['id_programa'],
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':orden' => $datos['orden'],
            ':horas' => $datos['horas']
        ]);

        return $this->conexion->lastInsertId();
    }

    // 4. ACTUALIZAR MODULO
    public function actualizar($id, $datos) {

        $sql = "UPDATE modulos_programa SET
                    id_programa = :id_programa,
                    nombre = :nombre,
                    descripcion = :descripcion,
                    orden = :orden,
                    horas = :horas
                WHERE id_modulo = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_programa' => $datos['id_programa'],
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':orden' => $datos['orden'],
            ':horas' => $datos['horas'],
            ':id' => $id
        ]);

        return $consulta->rowCount();
    }

    // 5. ELIMINAR MODULO
    public function eliminar($id) {

        $sql = "DELETE FROM modulos_programa
                WHERE id_modulo = :id";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->rowCount();
    }
}

