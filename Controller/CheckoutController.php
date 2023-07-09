<?php

namespace Controller;

use Database\Database;

class CheckoutController
{
    public static function saveCustomerData($customerData, $cartItems)
    {
        try {
            if ($customerData['userId']) {
                $stmt = Database::getInstance()->prepare("
                    UPDATE tbl_client 
                    SET name = :name, 
                        address = :address, 
                        postcode = :postcode, 
                        city = :city, 
                        state = :state, 
                        phone = :phone, 
                        email = :email 
                    WHERE id = :userId
                ");
                $stmt->bindValue(':name', $customerData['name']);
                $stmt->bindValue(':address', $customerData['address']);
                $stmt->bindValue(':postcode', $customerData['postcode']);
                $stmt->bindValue(':city', $customerData['city']);
                $stmt->bindValue(':state', $customerData['state']);
                $stmt->bindValue(':phone', $customerData['phone']);
                $stmt->bindValue(':email', $customerData['email']);
                $stmt->bindValue(':userId', $customerData['userId']);
                $stmt->execute();
            } else {
                $stmt = Database::getInstance()->prepare("
                    INSERT INTO tbl_client (name, address, postcode, city, state, phone, email)
                    VALUES (:name, :address, :postcode, :city, :state, :phone, :email)
                ");
                $stmt->bindValue(':name', $customerData['name']);
                $stmt->bindValue(':address', $customerData['address']);
                $stmt->bindValue(':postcode', $customerData['postcode']);
                $stmt->bindValue(':city', $customerData['city']);
                $stmt->bindValue(':state', $customerData['state']);
                $stmt->bindValue(':phone', $customerData['phone']);
                $stmt->bindValue(':email', $customerData['email']);
                $stmt->execute();
            }


            $customerId = Database::getInstance()->lastInsertId();

            $subtotal = 0;
            $total = 0;
            $orderDate = date('Y-m-d');
            $paymentType = 'Credit';
            $shipmentType = 2;

            foreach ($cartItems as $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
            }

            $total = $subtotal + 10; // 10 flat rate ship

            $stmt = Database::getInstance()->prepare("
                INSERT INTO tbl_invoice (customer_name, name, order_date, subtotal, total, paid, due, payment_type, shipment_type)
                VALUES (:customerName, :name, :orderDate, :subtotal, :total, :paid, :due, :paymentType, :shipmentType)
            ");
            $stmt->bindValue(':customerName', (!empty($customerData['userId'])) ? $customerData['userId'] : $customerId);
            $stmt->bindValue(':name', $customerData['name']);
            $stmt->bindValue(':orderDate', $orderDate);
            $stmt->bindValue(':subtotal', $subtotal);
            $stmt->bindValue(':total', $total);
            $stmt->bindValue(':paid', $total);
            $stmt->bindValue(':due', 0);
            $stmt->bindValue(':paymentType', $paymentType);
            $stmt->bindValue(':shipmentType', $shipmentType);
            $stmt->execute();

            $invoiceId = Database::getInstance()->lastInsertId();

            foreach ($cartItems as $cartItem) {
                $productId = $cartItem['productId'];
                $productName = $cartItem['productName'] . ' - ' . $cartItem['size'];
                $quantity = $cartItem['quantity'];
                $price = $cartItem['price'];

                $stmt = Database::getInstance()->prepare("
                    INSERT INTO tbl_invoice_details (invoice_id, product_id, product_name, qty, price, order_date)
                    VALUES (:invoiceId, :productId, :productName, :qty, :price, :orderDate)
                ");
                $stmt->bindValue(':invoiceId', $invoiceId);
                $stmt->bindValue(':productId', $productId);
                $stmt->bindValue(':productName', $productName);
                $stmt->bindValue(':qty', $quantity);
                $stmt->bindValue(':price', $price);
                $stmt->bindValue(':orderDate', $orderDate);
                $stmt->execute();
            }

            return 'success';
        } catch (\PDOException $e) {
            return 'error';
        }
    }
}
