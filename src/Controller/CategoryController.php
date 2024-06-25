<?php
namespace App\Controller;

use PDO;
use PDOException;

class CategoryController {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getCategoriesByCity($cityId) {
        header('Content-Type: application/json');

        // Validação e sanitização do ID da cidade
        $cityId = filter_var($cityId, FILTER_SANITIZE_NUMBER_INT);
        if (!filter_var($cityId, FILTER_VALIDATE_INT)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid city ID provided']);
            exit;
        }

        try {
            $stmt = $this->pdo->prepare("SELECT c.name FROM categories c
                                         JOIN city_categories cc ON c.id = cc.category_id
                                         WHERE cc.city_id = :cityId
                                         ORDER BY c.name ASC");
            $stmt->bindParam(':cityId', $cityId, PDO::PARAM_INT);
            $stmt->execute();

            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($categories)) {
                http_response_code(404);
                echo json_encode(['error' => 'No categories found for the provided city ID']);
            } else {
                echo json_encode(['categories' => $categories]);
            }
        } catch (PDOException $e) {
            error_log('Failed to fetch categories: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }
}
