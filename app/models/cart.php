<?php

class Cart
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getNumOfProductInTheCartByUserId($account_id)
    {
        $sql = "SELECT COUNT(*) AS num_rows FROM cart WHERE account_id = ?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $account_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $numOfProduct = 0;
        if ($row = $result->fetch_assoc()) {
            $numOfProduct = $row['num_rows'];
            return $numOfProduct;
        } else {
            return false;
        }
    }

    public function getAllOrdersInTheCart()
    {
        $sql = "SELECT * FROM  cart";
        $result = $this->__conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductsInTheCartByUserId($account_id)
    {
        $sql = "SELECT * FROM  cart WHERE account_id =?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $account_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    /**
     * 
     */
    public function deleteProductInTheCartById($cart_id)
    {
        $sql = 'DELETE FROM cart WHERE id = ?';
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->__conn->error);
            return false;
        }
        $stmt->bind_param('i', $cart_id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateQuantityOfProductInTheCartByCartId($cart_id, $quantity)
    {
        $sql = 'UPDATE cart SET quantity = ? WHERE id = ?'; // Sửa cart_id thành id
        $stmt = $this->__conn->prepare($sql);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->__conn->error);
            return false;
        }

        $stmt->bind_param('ii', $quantity, $cart_id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    public function getQuantityOfProductInTheCartByCartId($cart_id)
    {
        $sql = 'SELECT quantity FROM  cart WHERE cart_id =?';

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $cart_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $quantity = 0;
        if ($row = $result->fetch_assoc()) {
            $quantity = $row['quantity'];
            return $quantity;
        } else {
            return false;
        }
    }

    public function getJoinDataCartAndProducts($account_id)
    {
        $sql = 'SELECT cart.id, cart.quantity, cart.account_id, cart.product_id, cart.color_id, cart.size_id,
                       product.id AS product_id, product.price AS product_price, product.product_image, product.name AS product_name, product.image_folder,
                       color.description AS color, size.description AS size
                FROM cart
                JOIN product ON cart.product_id = product.id
                LEFT JOIN color ON cart.color_id = color.id
                LEFT JOIN size ON cart.size_id = size.id
                WHERE cart.account_id = ?';

        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->__conn->error);
        }

        $stmt->bind_param('i', $account_id);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if (!$result) {
            die("Get result failed: " . $stmt->error);
        }

        $cartItems = array();
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }

        $stmt->close();

        return $cartItems;
    }

    public function deleteAllProductsInTheCartByUserId($account_id)
    {
        $sql = 'DELETE FROM  cart WHERE account_id =?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return true;
        }
        return false;
    }

    public function getTotalAmountByUserId($account_id)
    {
        $sql = 'SELECT SUM( cart.quantity *  product.product_price) AS total_amount FROM  cart JOIN  product ON  cart.product_id =  product.product_id WHERE  cart.account_id =?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $totalAmount = 0;
        if ($row = $result->fetch_assoc()) {
            $totalAmount = $row['total_amount'];
            return $totalAmount;
        } else {
            return false;
        }
    }

    public function checkProductExistInCart($account_id, $product_id)
    {
        $sql = 'SELECT * FROM  cart WHERE account_id = ? AND product_id = ?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('si', $account_id, $product_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateQuantityProduct($account_id, $product_id, $quantity)
    {
        $sql = 'UPDATE cart SET quantity = quantity + ? WHERE account_id = ? AND product_id = ?';
        $stmt = $this->__conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $this->__conn->error;
            return false;
        }

        $stmt->bind_param('iii', $quantity, $account_id, $product_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // public function addToCart($account_id, $product_id, $quantity) {
    //     $sql = 'INSERT INTO cart (account_id, product_id, quantity) VALUES (?,?,?)';
    //     $stmt = $this->__conn->prepare($sql);
    //     $stmt->bind_param('sii', $account_id, $product_id, $quantity);
    //     if ($stmt->execute()) {
    //         $stmt->close(); 
    //         return true; 
    //     }
    //     return false;
    //     $stmt->close();
    // }

    public function checkQuantityProductById($product_id)
    {
        $sql = 'select COUNT(*) FROM product_seri WHERE product_id = ?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $quantity = 0;
        if ($row = $result->fetch_assoc()) {
            $quantity = $row['COUNT(*)'];
            return $quantity;
        } else {
            return false;
        }
    }

    public function checkQuantityInStockByProductById($product_id)
    {
        $sql = 'SELECT COUNT(*) AS total_count FROM product_seri WHERE product_id = ? AND status = 1';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $quantity = 0;
        if ($row = $result->fetch_assoc()) {
            $quantity = $row['total_count'];
            return $quantity;
        } else {
            return false;
        }

    }

    public function addToCart($account_id, $product_id, $quantity, $color_description, $size_description)
    {
        // Lấy color_id từ description
        $colorQuery = "SELECT id FROM color WHERE description = ?";
        $colorStmt = $this->__conn->prepare($colorQuery);
        $colorStmt->bind_param('s', $color_description);
        $colorStmt->execute();
        $colorResult = $colorStmt->get_result()->fetch_assoc();
        $color_id = $colorResult ? $colorResult['id'] : null;

        // Lấy size_id từ description
        $sizeQuery = "SELECT id FROM size WHERE description = ?";
        $sizeStmt = $this->__conn->prepare($sizeQuery);
        $sizeStmt->bind_param('s', $size_description);
        $sizeStmt->execute();
        $sizeResult = $sizeStmt->get_result()->fetch_assoc();
        $size_id = $sizeResult ? $sizeResult['id'] : null;

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $checkQuery = "SELECT id, quantity FROM cart WHERE account_id = ? AND product_id = ? AND color_id = ? AND size_id = ?";
        $checkStmt = $this->__conn->prepare($checkQuery);
        $checkStmt->bind_param('iiii', $account_id, $product_id, $color_id, $size_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // Nếu sản phẩm đã tồn tại, cập nhật số lượng
            $row = $result->fetch_assoc();
            $newQuantity = $row['quantity'] + $quantity;
            $updateQuery = "UPDATE cart SET quantity = ? WHERE id = ?";
            $updateStmt = $this->__conn->prepare($updateQuery);
            $updateStmt->bind_param('ii', $newQuantity, $row['id']);
            return $updateStmt->execute();
        } else {
            // Nếu sản phẩm chưa tồn tại, thêm mới
            $insertQuery = "INSERT INTO cart (account_id, product_id, quantity, color_id, size_id) VALUES (?, ?, ?, ?, ?)";
            $insertStmt = $this->__conn->prepare($insertQuery);
            $insertStmt->bind_param('iiiii', $account_id, $product_id, $quantity, $color_id, $size_id);
            return $insertStmt->execute();
        }
    }


}