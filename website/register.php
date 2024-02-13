<?php 
include './components/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

//register user
if(isset($_POST['submit'])) {
    $id = unique_id();

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    $sex = $_POST['gender']; // Récupérer la valeur du champ sex

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);

    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0) {
        $message[] = 'email already exist';
        echo 'email already exist';
    }else{
        if($pass != $cpass){
            $message[] = 'confirm your password';
            echo 'confirm your password';
        }else{
            $insert_user = $conn->prepare("INSERT INTO `users` (id, name, email, password, gender) VALUES(?,?,?,?,?)"); // Ajouter la colonne sex dans la requête SQL
            $insert_user->execute([$id,$name,$email,$pass,$sex]); // Inclure la valeur de sex dans l'exécution de la requête
            header('location: home.php');
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
            $select_user->execute([$email, $pass]);
            $row = $select_user->fetch(PDO:FETCH_ASSOC);
            if($select_user->rowCount() > 0) {
                $_SESSION['user_id'] = $row['id'];    
                $_SESSION['user_name'] = $row['name'];    
                $_SESSION['user_email'] = $row['email'];    
            }
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
    <title>green tea - register now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="./img/download.png" alt="">
                <h1>register now</h1>
                <p>Explore a world of exquisite flavors at our green tea emporium, where each sip is a journey.</p>
            </div>
            <form method="post">
                <div class="input-field">
                    <p class="required-field">your name</p>
                    <input type="text" name="name" require placeholder="enter your name" maxlength="50">
                </div>
                <div class="input-field">
                    <p class="required-field">your email</p>
                    <input type="email" name="email" require placeholder="enter your email" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p class="required-field">your password</p>
                    <input type="password" name="pass" require placeholder="enter your password" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p class="required-field">Confirm password</p>
                    <input type="password" name="cpass" require placeholder="confirm password" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <!-- Ajouter le champ sex -->
                <div class="input-field">
                    <p class="required-field">Your gender</p>
                    <select name="gender" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <input type="submit" name="submit" value="register now" class="btn">
                <p>already have an account? <a href="login.php">login now</a></p>
            </form>
        </section>
    </div>
    
</body>
</html>
