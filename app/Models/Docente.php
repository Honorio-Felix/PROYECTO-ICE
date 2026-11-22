
<?php

require_once __DIR__ . '/../../config/Conexion.php';

class Docente {

    private $conexion;

    public function __construct() {
        $database = new Conexion();
        $this->conexion = $database->conectar();
    }

    // 1. LISTAR DOCENTES
    public function listar() {

        $sql = "SELECT *
                FROM docentes
                ORDER BY id_docente";

        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. BUSCAR DOCENTE POR ID
    public function buscarPorId($id) {

        $sql = "SELECT *
                FROM docentes
                WHERE id_docente = :id";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // 3. CREAR DOCENTE
    public function crear($datos) {

        $sql = "INSERT INTO docentes (
                    nombres,
                    apellidos,
                    especialidad,
                    perfil_profesional
                ) VALUES (
                    :nombres,
                    :apellidos,
                    :especialidad,
                    :perfil_profesional
                )";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':nombres' => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':especialidad' => $datos['especialidad'],
            ':perfil_profesional' => $datos['perfil_profesional']
        ]);

        return $this->conexion->lastInsertId();
    }

    // 4. ACTUALIZAR DOCENTE
    public function actualizar($id, $datos) {

        $sql = "UPDATE docentes SET
                    nombres = :nombres,
                    apellidos = :apellidos,
                    especialidad = :especialidad,
                    perfil_profesional = :perfil_profesional
                WHERE id_docente = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':nombres' => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':especialidad' => $datos['especialidad'],
            ':perfil_profesional' => $datos['perfil_profesional'],
            ':id' => $id
        ]);

        return $consulta->rowCount();
    }

    // 5. ELIMINAR DOCENTE
    public function eliminar($id) {

        $sql = "DELETE FROM docentes
                WHERE id_docente = :id";

        $consulta = $this->conexion->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->rowCount();
    }
}
