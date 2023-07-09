<?php

namespace Controller;

use Database\Database;

class UserController
{
    public static function createUser($firstName, $lastName, $email, $password)
    {
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            return "Please fill in all the required fields.";
        } else {
            try {
                $db = Database::getInstance();
                $sql = "INSERT INTO tbl_client (name, email, password) VALUES (?, ?, ?)";
                $stmt = $db->prepare($sql);
                $fullName = $firstName . ' ' . $lastName;
                $stmt->execute([$fullName, $email, $password]);
                $userId = $db->lastInsertId();

                return ["success" => true, "userId" => $userId];
            } catch (\PDOException $e) {
                return "error creating user: " . $e->getMessage();
            }
        }
    }
    public static function isUserExists($email)
    {
        try {
            $db = Database::getInstance();
            $sql = "SELECT COUNT(*) FROM tbl_client WHERE email = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$email]);
            $count = $stmt->fetchColumn();

            return $count > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }
    public static function userDetails($id)
    {
        try {
            $db = Database::getInstance();
            $sql = "SELECT * FROM tbl_client WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $user = $stmt->fetch();

            return $user;
        } catch (\PDOException $e) {
            return false;
        }
    }
    public static function updateUser($userId, $name, $email, $password)
    {
        try {
            $db = Database::getInstance();
            $sql = "UPDATE tbl_client SET name = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$name, $email, $password, $userId]);

            return ["success" => true, "isLo" => "User updated"];
        } catch (\PDOException $e) {
            return "error updating user: " . $e->getMessage();
        }
    }
    public static function getOrders($userId)
    {
        try {
            $db = Database::getInstance();
            $sql = "SELECT * FROM tbl_invoice WHERE customer_name = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$userId]);

            $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $orders;
        } catch (\PDOException $e) {
            return "error retrieving orders: " . $e->getMessage();
        }
    }
    public static function loginUser($email, $password)
    {
        try {
            $db = Database::getInstance();
            $sql = "SELECT * FROM tbl_client WHERE email = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($user && $user['password'] === $password) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['userId'] = $user['id'];
                $_SESSION['isLoggedIn'] = true;

                return ["success" => true, "status" => "logged in", "email" => $user['email'], "userId" => $user['id'], "isLoggedIn" => true];                
            } else {
                return ["success" => false, "status" => "fail login"];
            }
        } catch (\PDOException $e) {
            echo "error authenticating user: " . $e->getMessage();
        }
    }
}
