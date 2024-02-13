<!DOCTYPE html>
<?php
include '../components/connection.php';
session_start();

$productCountQuery = "SELECT * FROM products";
$runproductCountQuery = $conn->query($productCountQuery); // Using PDO query method
$productCount = $runproductCountQuery->rowCount();

$usersCountQuery = "SELECT * FROM users";
$runusersCountQuery = $conn->query($usersCountQuery); // Using PDO query method
$usersCount = $runusersCountQuery->rowCount();

$getUserQuery = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
$rungetUser = $conn->query($getUserQuery); // Using PDO query method

$ordersCountQuery = "SELECT * FROM orders";
$runOrdersCountQuery = $conn->query($ordersCountQuery); // Using PDO query method
$ordersCount = $runOrdersCountQuery->rowCount();

$getOrderQuery = "SELECT * FROM orders ORDER BY id DESC LIMIT 5";
$rungetOrder = $conn->query($getOrderQuery); // Using PDO query method

// Nouvelle requête pour obtenir le nombre d'utilisateurs par sexe
$genderCountQuery = "SELECT gender, COUNT(*) as count FROM users GROUP BY gender";
$runGenderCountQuery = $conn->query($genderCountQuery);
$genderData = $runGenderCountQuery->fetchAll(PDO::FETCH_ASSOC);

// Créer des tableaux associatifs pour les données du diagramme circulaire
$genderLabels = [];
$genderCounts = [];
foreach ($genderData as $data) {
    $genderLabels[] = $data['gender'];
    $genderCounts[] = $data['count'];
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Tea</title>
    <link rel="stylesheet" href="../styles/admin-basic.css">
    <link rel="stylesheet" href="../styles/admin-dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
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

        <div class="work-place">
            <div class="summary">
                <div class="products" onclick="location.href='manage-products.php'">
                    <img src=".\img\4.webp.png" alt="">
                    <h1><?php echo "$productCount Products"; ?></h1>
                    <p>All products</p>
                </div>
                <div class="users" onclick="location.href='manage-users.php'">
                    <img src=".\img\card0.jpg" alt="">
                    <h1><?php echo "$usersCount Users"; ?></h1>
                    <p>Registered users</p>
                </div>
                <div class="orders" onclick="location.href='manage-orders.php'">
                    <img src=".\img\10.jpg" alt="">
                    <h1><?php echo "$ordersCount Orders"; ?></h1>
                    <p>Pending orders</p>
                </div>
                <div class="admins">
                    <img src="..\img\admin.jpg" alt="">
                    <h1>1 Admin</h1>
                </div>
            </div>

            <div class="summary-two">
                <div class="users-two">
                    <h1> Latest Users </h1>
                    <div class="list">
                        <?php
                        while($rowUsers = $rungetUser->fetch(PDO::FETCH_ASSOC))
                        {
                            $userName = $rowUsers['name'];
                            $userID = $rowUsers['email'];
                            echo "<p>$userName</p><p class='right'> $userID</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="gender-chart">
                    <canvas id="genderPieChart"></canvas>
                </div>
              
            </div>
        </div>
    </div>
    
    <script>
    var ctx = document.getElementById('genderPieChart').getContext('2d');
    var genderPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($genderLabels); ?>,
            datasets: [{
                data: <?php echo json_encode($genderCounts); ?>,
                backgroundColor: [
                    'rgba(255, 0, 0, 0.7)', // Rouge
                    'rgba(0, 0, 255, 0.7)', // Bleu
                    // Ajoutez d'autres couleurs si nécessaire
                ],
            }]
        },
        options: {
            responsive: true, // Rendre le graphique responsive
            maintainAspectRatio: false, // Désactiver le maintien du ratio d'aspect
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom', // Position de la légende
                }
            }
        }
    });
</script>

    <script src="scripts/admin.js"></script>
</body>
</html>
