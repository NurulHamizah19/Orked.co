<?php

namespace Controller;

use Database\Database;

class ProductController
{
    public static function getAllProducts()
    {
        try {
            $stmt = Database::getInstance()->query("SELECT * FROM tbl_product");
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $products;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }
    public static function getProductById($productId)
    {
        try {
            $stmt = Database::getInstance()->prepare("SELECT * FROM tbl_product WHERE pid = :id");
            $stmt->bindParam(':id', $productId);
            $stmt->execute();
            $product = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $product;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

    public static function filterProducts($products, $categoryFilter, $sortFilter, $searchFilter)
    {
        if ($categoryFilter != 'All') {
            $filteredProducts = array_filter($products, function ($product) use ($categoryFilter) {
                return $product['pcategory'] == $categoryFilter;
            });
        } else {
            $filteredProducts = $products;
        }

        if (!empty($searchFilter)) {
            $filteredProducts = array_filter($filteredProducts, function ($product) use ($searchFilter) {
                $productName = strtolower($product['pname']);
                $searchText = strtolower($searchFilter);
                return strpos($productName, $searchText) !== false;
            });
        }

        switch ($sortFilter) {
            case 'price':
                usort($filteredProducts, function ($a, $b) {
                    return $a['saleprice'] - $b['saleprice'];
                });
                break;
            case 'price-desc':
                usort($filteredProducts, function ($a, $b) {
                    return $b['saleprice'] - $a['saleprice'];
                });
                break;
            default:
                break;
        }

        return $filteredProducts;
    }
}
