<?php
include '../components/connection.php';

$orderID = $_POST['orderID'];
$orderCommand = $_POST['orderCommand'];

echo "<script>alert('Order status was changed to \"$orderCommand\"')</script>";

if(isset($orderID) && isset($orderCommand)) {
    $changeStatusQuery = "UPDATE orders SET status=:orderCommand WHERE id= :orderID";
    $stmt = $conn->prepare($changeStatusQuery);
    $stmt->bindParam(':orderCommand', $orderCommand);
    $stmt->bindParam(':orderID', $orderID);

    if($stmt->execute()) {
        echo "<h1> Manage Orders</h1>";
        $getOrdersQuery = "SELECT * FROM orders";
        $stmt = $conn->query($getOrdersQuery);

        while($rowOrder = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orderID = $rowOrder['id'];
            $productID = $rowOrder['product_id'];
            $orderDate = $rowOrder['date'];
            $orderStatus = $rowOrder['status'];
            $orderName = $rowOrder['name'];
            $orderAddress = $rowOrder['address'];

            // Définir les boutons en fonction du statut de la commande
            $acceptButton = '';
            $shippedButton = '';
            $rejectButton = '';

            if($orderStatus == 1) {
                $acceptButton = "<button onClick='manageOrder(\"processing\",$orderID)' >Accept</button>";
                $shippedButton = "<button onClick='manageOrder(\"shipped\",$orderID)'>Shipped</button>";
                $rejectButton = "<button onClick='manageOrder(\"rejected\",$orderID)'>Reject</button>";
            } elseif($orderStatus == 2) {
                $shippedButton = "<button onClick='manageOrder(\"shipped\",$orderID)'>Shipped</button>";
                $rejectButton = "<button onClick='manageOrder(\"rejected\",$orderID)'>Reject</button>";
            } elseif($orderStatus == 3) {
                $rejectButton = "<button onClick='manageOrder(\"rejected\",$orderID)'>Reject</button>";
            }

            echo "
            <div class='order'>
                <h2># $orderID </h2>
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
                    $acceptButton
                    $shippedButton
                    $rejectButton
                </div>
            </div>";
        }
    } else {
        echo "<script>alert('Failed to change order status')</script>";
    }
} else {
    echo "<script>window.open('../home.php', '_self')</script>";
}
?>
