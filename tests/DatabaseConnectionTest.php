<?php
// tests/DatabaseConnectionTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../database/DatabaseInstaller.php';

class DatabaseConnectionTest extends TestCase
{
    public function testConnectionIsValid()
    {

        // Tentar criar uma instância do instalador do banco de dados
        $installer = new DatabaseInstaller();
        $this->assertInstanceOf(DatabaseInstaller::class, $installer);

        // Tentar estabelecer a conexão e verificar se não lança exceção
        $this->assertNotNull($installer->testConnection());
    }
}
