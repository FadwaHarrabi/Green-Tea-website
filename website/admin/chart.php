<?php
include '../components/connection.php';
session_start();

try {
    // Récupérer les données des produits depuis la base de données
    $productStmt = $conn->query("SELECT name, price FROM products");
    $productData = $productStmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir les données des produits en format JSON
    $productJsonData = json_encode(array_map(function($item) {
        return ['name' => $item['name'], 'price' => (float)$item['price']];
    }, $productData));

    // Récupérer les données des commandes depuis la base de données
    $orderStmt = $conn->query("SELECT status, COUNT(*) AS count FROM orders GROUP BY status");
    $orderData = $orderStmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir les données des commandes en format JSON
    $orderJsonData = json_encode($orderData);

    // Distribution des modes de paiement
    $paymentMethodData = $conn->query("SELECT method, COUNT(*) AS count FROM orders GROUP BY method")->fetchAll(PDO::FETCH_ASSOC);

    // Revenu total au fil du temps
    $revenueData = $conn->query("SELECT DATE(date) AS date, SUM(price * qty) AS total_revenue FROM orders GROUP BY DATE(date)")->fetchAll(PDO::FETCH_ASSOC);

    // Relation entre le prix et la quantité
    $scatterPlotData = $conn->query("SELECT price, qty FROM orders")->fetchAll(PDO::FETCH_ASSOC);

    // Répartition des revenus par produit
    $revenueBreakdownData = $conn->query("SELECT product_id, SUM(price * qty) AS total_revenue FROM orders GROUP BY product_id")->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}

// Fermer la connexion à la base de données (mettez ceci après la récupération des données)
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/admin-basic.css">
    <link rel="stylesheet" href="../styles/admin-dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Include compressed Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
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
                <li onclick="location.href='chart.php'">Charts</li>
                <li onclick="location.href='../home.php'">Logout</li>
            </ul>
        </div>
         <div class="main-content">
        <!-- First row -->
        <div class="chart-row">
            <div class="chart-container" style="width: 45%; height: 300px;">
                <canvas id="productChart"></canvas>
            </div>
            <div class="chart-container" style="width: 45%; height: 300px;">
                <canvas id="orderChart"></canvas>
            </div>
        </div>
        <!-- Second row -->
        <div class="chart-row">
            <div class="chart-container" style="width: 45%; height: 300px;">
                <canvas id="paymentMethodChart"></canvas>
            </div>
            <div class="chart-container" style="width: 45%; height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Configuration des options communes pour tous les graphiques
        var commonOptions = {
            responsive: true,
            maintainAspectRatio: false
        };

        // Configuration du graphique pour les produits
        var productData = <?php echo $productJsonData; ?>;
        var productNames = productData.map(item => item.name);
        var productPrices = productData.map(item => item.price);

        var productChartConfig = {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Product Price Distribution',
                    data: productPrices,
                    backgroundColor: '#8FBC8F', // Vert foncé
                    borderColor: '#2E8B57', // Vert mer
                    borderWidth: 1
                }]
            },
            options: commonOptions
        };

        // Configuration du graphique pour les commandes
        var orderData = <?php echo $orderJsonData; ?>;
        var orderStatuses = orderData.map(item => item.status);
        var orderCounts = orderData.map(item => item.count);

        var orderChartConfig = {
            type: 'bar',
            data: {
                labels: orderStatuses,
                datasets: [{
                    label: 'Order Status Distribution',
                    data: orderCounts,
                    backgroundColor: '#FF6347', // Rouge tomate
                    borderColor: '#DC143C', // Rouge cramoisi
                    borderWidth: 1
                }]
            },
            options: commonOptions
        };

        var paymentMethodChartConfig = {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($paymentMethodData, 'method')); ?>,
                datasets: [{
                    label: 'Payment Method Distribution',
                    data: <?php echo json_encode(array_column($paymentMethodData, 'count')); ?>,
                    backgroundColor: ['#32CD32', '#3CB371', '#228B22', '#556B2F', '#006400'], // Différentes nuances de vert
                    borderWidth: 1
                }]
            },
            options: commonOptions
        };

        var revenueChartConfig = {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($revenueData, 'date')); ?>,
                datasets: [{
                    label: 'Total Revenue Over Time',
                    data: <?php echo json_encode(array_column($revenueData, 'total_revenue')); ?>,
                    backgroundColor: '#7FFF00', // Vert chartreuse
                    borderColor: '#ADFF2F', // Vert vert
                    borderWidth: 1
                }]
            },
            options: commonOptions
        };

        // Créer les graphiques
        var productChart = new Chart(document.getElementById('productChart').getContext('2d'), productChartConfig);
        var orderChart = new Chart(document.getElementById('orderChart').getContext('2d'), orderChartConfig);
        var paymentMethodChart = new Chart(document.getElementById('paymentMethodChart').getContext('2d'), paymentMethodChartConfig);
        var revenueChart = new Chart(document.getElementById('revenueChart').getContext('2d'), revenueChartConfig);
    </script>
</body>
</html>

