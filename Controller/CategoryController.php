<?php

namespace Controller;

use Database\Database;

class CategoryController
{
    public static function getAllCategories()
    {
        try {
            $stmt = Database::getInstance()->query("SELECT * FROM tbl_category");
            $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $categories;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

    public static function getCategoryById($categoryId)
    {
        try {
            $stmt = Database::getInstance()->prepare("SELECT * FROM tbl_category WHERE catid = :id");
            $stmt->bindParam(':id', $categoryId);
            $stmt->execute();
            $category = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $category;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

    public static function getProductsByCategory($categoryName)
    {
        try {
            $stmt = Database::getInstance()->prepare("SELECT * FROM tbl_product WHERE pcategory = :category_name");
            $stmt->bindParam(':category_name', $categoryName);
            $stmt->execute();
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $products;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }
}
