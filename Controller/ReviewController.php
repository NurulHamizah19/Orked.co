<?php

namespace Controller;

use Database\Database;

class ReviewController
{
    public static function getLatestReviews()
    {
        try {
            $stmt = Database::getInstance()->query("SELECT * FROM review ORDER BY timestamp DESC LIMIT 5");
            $reviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $reviews;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }
    public static function saveReview($name, $email, $rating, $comment)
    {
        try {
            $stmt = Database::getInstance()->prepare("
                INSERT INTO review (name, email, rating, comment)
                VALUES (:name, :email, :rating, :comment)
            ");
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':rating', $rating);
            $stmt->bindValue(':comment', $comment);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
