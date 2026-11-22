
<?php

require_once __DIR__ . '/../../config/Conexion.php';

class Prospecto {

    private $conexion;

    public function __construct() {
        $database = new Conexion();
        $this->conexion = $database->conectar();
    }

    // 1. LISTAR PROSPECTOS
    public function listar() {

        $sql = "SELECT *
                FROM prospectos
                ORDER BY id_prospecto";

        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. BUSCAR PROSPECTO POR ID
    public function buscarPorId($id) {

        $sql = "SELECT *
                FROM prospectos
                WHERE id_prospecto = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // 3. CREAR PROSPECTO
    public function crear($datos) {

        $sql = "INSERT INTO prospectos (
                    nombres_apellidos,
                    correo,
                    telefono,
                    perfil
                ) VALUES (
                    :nombres_apellidos,
                    :correo,
                    :telefono,
                    :perfil
                )";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':nombres_apellidos' => $datos['nombres_apellidos'],
            ':correo' => $datos['correo'],
            ':telefono' => $datos['telefono'],
            ':perfil' => $datos['perfil']
        ]);

        return $this->conexion->lastInsertId();
    }

    // 4. ACTUALIZAR PROSPECTO
    public function actualizar($id, $datos) {

        $sql = "UPDATE prospectos SET
                    nombres_apellidos = :nombres_apellidos,
                    correo = :correo,
                    telefono = :telefono,
                    perfil = :perfil
                WHERE id_prospecto = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':nombres_apellidos' => $datos['nombres_apellidos'],
            ':correo' => $datos['correo'],
            ':telefono' => $datos['telefono'],
            ':perfil' => $datos['perfil'],
            ':id' => $id
        ]);

        return $consulta->rowCount();
    }

    // 5. ELIMINAR PROSPECTO
    public function eliminar($id) {

        $sql = "DELETE FROM prospectos
                WHERE id_prospecto = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->rowCount();
    }
}
