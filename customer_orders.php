<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>

<h1>Customer Orders with Joins</h1>

<h2>INNER JOIN: Customers with their Orders</h2>
<table>
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Order ID</th>
            <th>Order Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "
            SELECT 
                Customers.name AS customer_name,
                Customers.email AS customer_email,
                Orders.order_id,
                Orders.order_date
            FROM 
                Customers
            INNER JOIN 
                Orders ON Customers.customer_id = Orders.customer_id
        ";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['customer_email']}</td>
                    <td>{$row['order_id']}</td>
                    <td>{$row['order_date']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<h2>LEFT OUTER JOIN: Orders with Payments</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Payment Amount</th>
            <th>Payment Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "
            SELECT 
                Orders.order_id,
                Orders.order_date,
                Payments.amount,
                Payments.payment_status
            FROM 
                Orders
            LEFT JOIN 
                Payments ON Orders.order_id = Payments.order_id
        ";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['order_date']}</td>
                    <td>" . ($row['amount'] ? $row['amount'] : 'N/A') . "</td>
                    <td>" . ($row['payment_status'] ? $row['payment_status'] : 'N/A') . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<h2>LEFT OUTER JOIN: Orders with Products</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "
            SELECT 
                Orders.order_id,
                Products.name AS product_name,
                OrderDetails.quantity
            FROM 
                Orders
            LEFT JOIN 
                OrderDetails ON Orders.order_id = OrderDetails.order_id
            LEFT JOIN 
                Products ON OrderDetails.product_id = Products.product_id
        ";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>" . ($row['product_name'] ? $row['product_name'] : 'N/A') . "</td>
                    <td>" . ($row['quantity'] ? $row['quantity'] : 'N/A') . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
