<?php
namespace App\Controller;

class UserController {
    // private $dbConnection;

    // public function __construct() {
    //     $this->dbConnection = new DatabaseInstaller()->getPdo();
    // }

    // public function getUsers() {
    //     // Exemplo de consulta
    //     $stmt = $this->dbConnection->query('SELECT * FROM users');
    //     return $stmt->fetchAll();
    // }


    public static function index() {
        return 'Hello, World!';
    }

    public static function teste() {
        return 'Hello, World!21';
    }
}