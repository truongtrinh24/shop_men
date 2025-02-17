
<?php

class Cart
{
    private $__conn;

    function __construct(){
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getNumOfProductInTheCartByUserId($account_id) {
        $sql = "SELECT COUNT(*) AS num_rows FROM cart WHERE account_id = ?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $account_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $numOfProduct = 0;
        if($row = $result->fetch_assoc()) {
            $numOfProduct = $row['num_rows'];
            return $numOfProduct;
        } else {
            return false;
        }
    }

    public function getAllOrdersInTheCart() {
        $sql = "SELECT * FROM  cart";
        $result = $this->__conn->query($sql);
        if($result) {
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductsInTheCartByUserId($account_id) {
        $sql = "SELECT * FROM  cart WHERE account_id =?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $account_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result) {
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
/**
 * 
 */
    public function deleteProductInTheCartById($cart_id) {
        $sql = 'DELETE FROM  cart WHERE cart_id = ?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $cart_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result) {
            return true;
        }
        return false;
    }

    public function updateQuantityOfProductInTheCartByCartId($cart_id, $quantity) {
        $sql = 'UPDATE  cart SET quantity = ? WHERE cart_id = ?';
        $stmt = $this->__conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $this->__conn->error;
            return false;
        }

        $stmt->bind_param('ii', $quantity, $cart_id); 

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getQuantityOfProductInTheCartByCartId($cart_id) {
        $sql = 'SELECT quantity FROM  cart WHERE cart_id =?';

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $cart_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $quantity = 0;
        if($row = $result->fetch_assoc()) {
            $quantity = $row['quantity'];
            return $quantity;
        } else {
            return false;
        }
    }

    public function getJoinDataCartAndProducts() {
        $sql = 'SELECT  cart.quantity,  cart.cart_id, product.product_id, product.product_price,  product.product_image,  product.product_name
                FROM  cart JOIN  product ON  cart.product_id =  product.product_id
                WHERE  cart.account_id = ?';

        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->__conn->error);
        }

        $account_id = isset($_SESSION['user_session']['user']['account_id']) ? $_SESSION['user_session']['user']['account_id'] : null;
        $stmt->bind_param('s', $account_id);

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
    
    public function deleteAllProductsInTheCartByUserId($account_id) {
        $sql = 'DELETE FROM  cart WHERE account_id =?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result) {
            return true;
        }
        return false;
    }
    
    public function getTotalAmountByUserId($account_id) {
        $sql = 'SELECT SUM( cart.quantity *  product.product_price) AS total_amount FROM  cart JOIN  product ON  cart.product_id =  product.product_id WHERE  cart.account_id =?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $totalAmount = 0;
        if($row = $result->fetch_assoc()) {
            $totalAmount = $row['total_amount'];
            return $totalAmount;
        } else {
            return false;
        }
    }

    public function checkProductExistInCart($account_id, $product_id) {
        $sql = 'SELECT * FROM  cart WHERE account_id = ? AND product_id = ?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('si', $account_id, $product_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateQuantityProduct($account_id, $product_id, $quantity) {
        $sql = 'UPDATE cart SET quantity = quantity + ? WHERE account_id = ? AND product_id = ?';
        $stmt = $this->__conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $this->__conn->error;
            return false;
        }

        $stmt->bind_param('iii',$quantity, $account_id, $product_id); 

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function addToCart($account_id, $product_id, $quantity) {
        $sql = 'INSERT INTO cart (account_id, product_id, quantity) VALUES (?,?,?)';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('sii', $account_id, $product_id, $quantity);
        if ($stmt->execute()) {
            $stmt->close(); 
            return true; 
        }
        return false;
        $stmt->close();
    }

    public function checkQuantityProductById($product_id) {
        $sql = 'select COUNT(*) FROM product_seri WHERE product_id = ?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $quantity = 0;
        if($row = $result->fetch_assoc()) {
            $quantity = $row['COUNT(*)'];
            return $quantity;
        } else {
            return false;
        }
    }

    public function checkQuantityInStockByProductById($product_id) {
        $sql = 'SELECT COUNT(*) AS total_count FROM product_seri WHERE product_id = ? AND status = 1';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $quantity = 0;
        if($row = $result->fetch_assoc()) {
            $quantity = $row['total_count'];
            return $quantity;
        } else {
            return false;
        }

    }
    
}