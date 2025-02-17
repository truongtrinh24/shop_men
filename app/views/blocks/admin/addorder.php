<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
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


    <form action="<?php echo _WEB_ROOT; ?>/xu-ly-them-hoa-don" method="post">

        <label for="customer">Chọn Khách Hàng:</label>
        <select name="customer_id" id="customer_id">
            <?php foreach ($customers as $customer) : ?>
                <option value="<?php echo htmlspecialchars($customer['customer_id']); ?>">
                    <?php echo htmlspecialchars($customer['customer_id']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="employee">Chọn Nhân Viên:</label>
        <select name="employee_id" id="employee_id">
            <?php foreach ($employees as $employee) : ?>
                <option value="<?php echo htmlspecialchars($employee['employee_id']); ?>">
                    <?php echo htmlspecialchars($employee['employee_id']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="status_order_id">Trạng Thái:</label>
        <select name="status_order_id" id="status_order_id" required>
            <option value="1">Chờ Xử Lý</option>
            <option value="2">Đã Xử Lý</option>
            <option value="3">Đã Hủy</option>
        </select>


        <!-- Các trường khác của form... -->
        <!-- Trường nhập tổng cộng -->
        <input type="text" name="total" placeholder="Tổng Cộng" required>

        <!-- Trường chọn ngày mua -->
        <label for="date_buy">Ngày Mua:</label>
        <input type="date" id="date_buy" name="date_buy" required>

        <input type="submit" value="Thêm Hóa Đơn">
    </form>
</body>

</html>