
<?php

class Conexion {

    private $host;
    private $db;
    private $user;
    private $password;

    public function __construct() {

        // Ubicar el archivo .env en la raiz del proyecto
        $archivoEnv = __DIR__ . '/../.env';

        if (!file_exists($archivoEnv)) {
            throw new Exception("No se encontró el archivo .env");
        }

        $config = parse_ini_file($archivoEnv);

        if ($config === false) {
            throw new Exception("No se pudo leer el archivo .env");
        }

        // Verificar que existan las configuraciones necesarias
        $campos = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];

        foreach ($campos as $campo) {
            if (!array_key_exists($campo, $config)) {
                throw new Exception("Falta configurar {$campo} en el archivo .env");
            }
        }

        $this->host = $config['DB_HOST'];
        $this->db = $config['DB_NAME'];
        $this->user = $config['DB_USER'];
        $this->password = $config['DB_PASS'];
    }

    public function conectar() {

        try {

            $conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            return $conexion;

        } catch (PDOException $e) {

            error_log("Error de conexión PDO: " . $e->getMessage());

            throw $e;
        }
    }
}