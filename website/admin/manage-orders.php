<!DOCTYPE html>
<?php
include '../components/connection.php';
session_start();

// Fetching orders data
$getOrdersQuery = "SELECT * FROM orders";
$runOrdersQuery = $conn->query($getOrdersQuery);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../styles/admin-basic.css">
    <link rel="stylesheet" href="../styles/admin-manage-orders.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
    <div class="side-bar">
        <a href="dashboard.php" class="logo"><img src="../img/logo.jpg" alt=""></a>
        
        <ul>
                <li onclick="location.href='dashboard.php'">Dashboard</li>
                <li onclick="location.href='manage-products.php'">Manage Products</li>
                <li onclick="location.href='manage-users.php'">Manage Users</li>
                <li onclick="location.href='manage-orders.php'">Manage Orders</li>
                <li onclick="location.href='manage-contact.php'">Manage Contact</li>
                <li onclick="location.href='chart.php'">chart</li>
                <li onclick="location.href='../home.php'">Logout</li>
            </ul>
    </div>

        <div class="orders-container">
            <h1> Manage Orders</h1>
            <?php
                while($rowOrder = $runOrdersQuery->fetch(PDO::FETCH_ASSOC)) {
                    $orderID = $rowOrder['id'];
                    $productID = $rowOrder['product_id'];
                    $orderDate = $rowOrder['date'];
                    $orderStatus = $rowOrder['status'];
                    $orderName = $rowOrder['name'];
                    $orderAddress = $rowOrder['address'];

                    echo"
                    <div class='order'>
                    <h2>#$orderID </h2>
                        <div class='main'>
                            <div class='order-details'>
                                <p>Product ID: <span> $productID</span></p>
                                <p>Order Date: <span>$orderDate</span></p>
                                <p>Order Status: <span>$orderStatus</span></p>
                            </div>
                            <div class='order-user'>
                                <p>Name: <span> $orderName</span></p>
                                <p>Address: <span>$orderAddress</span></p>
                            </div>
                        </div>
                        <div class='controller'>
                            <button class='controller-btns' onClick='manageOrder(\"Accept\",$orderID)' >Accept</button>
                            <button class='controller-btns' onClick='manageOrder(\"shipped\",$orderID)'>Shipped</button>
                            <button class='controller-btns' onClick='manageOrder(\"rejected\",$orderID)'>Reject</button>
                        </div>
                    </div>
                    ";
                }
            ?>
           
        </div>

    </div>
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../scripts/admin.js"></script>
</body>

</html>