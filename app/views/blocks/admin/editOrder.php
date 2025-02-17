<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select,
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <form action="<?php echo _WEB_ROOT; ?>/cap-nhat-hoa-don/<?php echo $order_info['order_id']; ?>" method="post">
      
        <label for="status_order_id">Trạng Thái:</label>
        <select name="status_order_id" id="status_order_id" required>
            <option value="1" <?php echo $order_info['status_order_id'] == 1 ? 'selected' : ''; ?>>Chờ Xử Lý</option>
            <option value="2" <?php echo $order_info['status_order_id'] == 2 ? 'selected' : ''; ?>>Đã Xử Lý</option>
            <option value="3" <?php echo $order_info['status_order_id'] == 3 ? 'selected' : ''; ?>>Đã Hủy</option>
        </select>


        <input type="submit" value="Cập Nhật Hóa Đơn">
    </form>

    <!-- Kết thúc của file editOrder.php -->
</body>

</html>