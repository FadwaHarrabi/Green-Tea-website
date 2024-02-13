<?php 
include './components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
if(isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-btn'])) {
    // Récupère les données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $message = $_POST['message'];
    
    // Récupère la date et l'heure actuelles
    $created_at = date("Y-m-d H:i:s");

    // Prépare la requête d'insertion
    $query = "INSERT INTO contact (name, email, number, message, created_at) VALUES (:name, :email, :number, :message, :created_at)";

    // Prépare la déclaration PDO
    $stmt = $conn->prepare($query);

    // Lie les valeurs et exécute la requête
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":number", $number);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":created_at", $created_at);

    // Exécute la requête
    if ($stmt->execute()) {
        // Succès de l'insertion
        echo '<script>alert("Message sent successfully!");</script>';
    } else {
        // Échec de l'insertion
        echo '<script>alert("Failed to send message. Please try again later.");</script>';
    }

    // Ferme la connexion
    $stmt->closeCursor();
   
}
?>



<style type="text/css">
    <?php include 'style.css'; ?>
</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Coffee - home page</title>
</head>
<body>
    
<?php  include './components/header.php'; ?>
<div class="main">
<div class="banner">
        <h1>Contact us</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span>/ Contact us</span>
    </div>
    <section class="services">
        <div class="box-container">
            <div class="box">
                <img src="./img/icon2.png" alt="">
                <div class="detail">
                    <h3>great saving</h3>
                    <p>save big every order</p>
                </div>
            </div>
            <div class="box">
                <img src="./img/icon1.png" alt="">
                <div class="detail">
                    <h3>24*7 support</h3>
                    <p>one-on-one support</p>
                </div>
            </div>
            <div class="box">
                <img src="./img/icon0.png" alt="">
                <div class="detail">
                    <h3>gift vouchers</h3>
                    <p>vouchers on every festivals</p>
                </div>
            </div>
            <div class="box">
                <img src="./img/icon.png" alt="">
                <div class="detail">
                    <h3>worldwide delivery</h3>
                    <p>dropship worldwide</p>
                </div>
            </div>
        </div>
    </section>
    <div class="form-container">
        <form method="post">
            <div class="title">
                <img src="./img/download.png" class="logo" alt="">
                <h1>Leave a message</h1>
            </div>
            <div class="input-field">
                <p class="required-field">your name</p>
                <input type="text" name="name" required>
            </div>
            <div class="input-field">
                <p class="required-field">your email</p>
                <input type="email" name="email" required>
            </div>
            <div class="input-field">
                <p class="required-field">your number</p>
                <input type="text" name="number" required>
            </div>
            <div class="input-field">
                <p  class="required-field">your message</p>
                <textarea name="message" required></textarea>
            </div>
            <button type="submit" name="submit-btn" class="btn">send message</button>
        </form>
        
    </div>
    <div class="address">
        <div class="title">
                <img src="./img/download.png" class="logo" alt="">
                <h1>contact detail</h1>
                <p>Immerse yourself in the world of green coffee excellence, where each cup narrates a tale of craftsmanship and passion.!</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>address</h4>
                        <p>Tunisia-</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-phone-call"></i>
                    <div>
                        <h4>phone number</h4>
                        <p>+216 22565859</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>email</h4>
                        <p>GreenTea@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    <?php include 'components/footer.php'?>
</div>
<script src="http://cdnjs.Cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php  include './components/alert.php'; ?>
</body>
</html>