<?php
// Incluir o autoload do Composer para carregamento automático de classes
namespace Database;

use PDO;
use PDOException;

// require_once __DIR__ . '/../vendor/autoload.php';

class DatabaseInstaller {
    private $pdo;

    private $host;
    private $db;
    private $user;
    private $pass;

    public function __construct() {
        $this->host = getenv('DB_HOST');
        $this->db   = getenv('DB_NAME');
        $this->user = getenv('DB_USER');
        $this->pass = getenv('DB_PASS');
        $this->initializeConnection();

    }

    private function initializeConnection() {
        // Acessando as variáveis de ambiente
        
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
            echo "Conexão estabelecida!";
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function runSqlFromFile($filePath) {
        $sql = file_get_contents($filePath);
        
        if ($sql === false) {
            die("Não foi possível ler o arquivo $filePath");
        }

        try {
            $this->pdo->exec($sql);
            echo "SQL executado com sucesso: $filePath\n";
        } catch (PDOException $e) {
            die("Erro ao executar SQL: " . $e->getMessage());
        }
    }

    // Metodo para utilizar nos testes
    public function testConnection() {
        return $this->pdo;
    }

    public function migrateAllTables() {
        $sqlFilePaths[] = __DIR__ . '/migrations/001_cities_table_create.sql';
        $sqlFilePaths[] = __DIR__ . '/migrations/002_categories_table_create.sql';
        $sqlFilePaths[] = __DIR__ . '/migrations/003_city_categories_table_create.sql';
        $sqlFilePaths[] = __DIR__ . '/migrations/004_fare_calculations_table_create.sql';

        $this->executeSqlsFromArray($sqlFilePaths);
    }

    public function seederAllTables() {
        $sqlFilePaths[] = __DIR__ . '/seeders/001_seed_cities_table.sql';
        $sqlFilePaths[] = __DIR__ . '/seeders/002_seed_categories_table.sql';
        $sqlFilePaths[] = __DIR__ . '/seeders/003_seed_city_categories_table.sql';

        $this->executeSqlsFromArray($sqlFilePaths);
    }

    public function executeSqlsFromArray ($sqlFilePaths) {
        $installer = new DatabaseInstaller($this->host, $this->db, $this->user, $this->pass);
        for ($i=0; $i < count($sqlFilePaths); $i++) { 
            $installer->runSqlFromFile($sqlFilePaths[$i]);
        }
    }
}
