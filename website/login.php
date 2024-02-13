<?php 
include './components/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);

    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'];    
        $_SESSION['user_name'] = $row['name'];    
        $_SESSION['user_email'] = $row['email'];

        // Vérifiez si l'utilisateur est un administrateur
        if ($row['user_type'] == 'admin') {
            header('location: .\admin\dashboard.php');  // Redirige vers le tableau de bord de l'administrateur
        } else {
            header('location: home.php');  // Redirige vers la page principale pour les utilisateurs normaux
        }
    } else {
        // Vérifiez si le mot de passe ou l'email est incorrect et affichez un message approprié
        if ($select_user->rowCount() == 0) {
            $message[] = 'Invalid email or password';
        } elseif ($select_user->rowCount() == 1 && $row['email'] != $email) {
            $message[] = 'Invalid email';
        } elseif ($select_user->rowCount() == 1 && $row['password'] != $pass) {
            $message[] = 'Invalid password';
        }
    }
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
    <title>Green Tea - Login Now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="./img/download.png" alt="">
                <h1>Login Now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, excepturi?</p>
            </div>
            <form method="post">
                <div class="input-field">
                    <p>Your Email</p>
                    <input type="email" name="email" require placeholder="Enter your email" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Your Password</p>
                    <input type="password" name="pass" require placeholder="Enter your password" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="Login Now" class="btn">
                <p>Don't have an account? <a href="register.php">Register Now</a></p>
            </form>
        </section>
    </div>
</body>
</html>
