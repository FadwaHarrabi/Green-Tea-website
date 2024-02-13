<?php
require 'connection.php';

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $product_detail = $_POST["product_detail"];

    if ($_FILES["image"]["error"] === 4) {
        echo "<script> alert('Image does not exist');</script>";
    } else {
        $image_name = $_FILES["image"]["name"];
        $image_tmp = $_FILES["image"]["tmp_name"];
        $image_size = $_FILES["image"]["size"];
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $ImageExtension = explode('.', $image_name);
        $ImageExtension = strtolower(end($ImageExtension));

        if (!in_array($ImageExtension, $validImageExtension)) {
            echo "<script> alert('Invalid image type. Please choose a valid image file.');</script>";
        } else {
            $newimagename = uniqid();
            $newimagename .= '.' . $ImageExtension;
            move_uploaded_file($image_tmp, 'img/' . $newimagename);

            $query = "INSERT INTO products (name, price, image, product_detail) VALUES ('$name', '$price', '$newimagename', '$product_detail')";
            mysqli_query($conn, $query);

            echo "<script> 
                alert('Successfully added');
                document.location.href='data.php';
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload image file</title>
</head>
<body>
    <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
        

        <label for="name">Nom du produit :</label>
        <input type="text" id="name" name="name" required value=""><br>

        <label for="price">Prix :</label>
        <input type="text" id="price" name="price" required value=""><br>

        <label for="image">Choisir une image (png, jpg, jpeg) :</label>
        <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" required><br>

        <label for="product_detail">Détails du produit :</label>
        <textarea id="product_detail" name="product_detail" required></textarea><br>

        <input type="submit" name="submit" value="Envoyer">
    </form>
    <br>
    <a href="data.php">Data</a>
</body>
</html>
