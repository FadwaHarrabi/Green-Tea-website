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
// Adding products in wishlist
if(isset($_POST['add_to_wishlist'])) {
    $id = unique_id();
    $product_id = $_POST['product_id'];

    $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $varify_wishlist->execute([$user_id, $product_id]);

    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $product_id]);

    if($varify_wishlist->rowCount() > 0) {    
        $warning_msg[] = 'product already exist in wishlist';
    }else if ($cart_num->rowCount() > 0) {
        $warning_msg[] = 'product already exist in cart';
    }else{
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id, product_id, price) VALUES(?,?,?,?)");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
        $success_msg[] = 'product added to wishlist successfully';
    }
}

// Adding products in cart
if(isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    // Vérification de la quantité
    $qty = filter_var($qty, FILTER_VALIDATE_INT);
    if($qty === false || $qty <= 0) {
        $warning_msg[] = 'Invalid quantity';
    } else {
        // Vérification de l'existence du produit dans le panier
        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $verify_cart->execute([$user_id, $product_id]);
        
        if($verify_cart->rowCount() > 0) {    
            $warning_msg[] = 'Product already exists in the cart';
        } else {
            // Vérification de la capacité du panier
            $max_cart_items = $conn->prepare("SELECT SUM(qty) as total_qty FROM `cart` WHERE user_id = ?");
            $max_cart_items->execute([$user_id]);
            $cart_info = $max_cart_items->fetch(PDO::FETCH_ASSOC);
            $total_qty = $cart_info['total_qty'] + $qty;

            if($total_qty > 20) {
                $warning_msg[] = 'Cart is full';
            } else {
                // Récupération du prix du produit
                $select_price = $conn->prepare("SELECT price FROM `products` WHERE id = ? LIMIT 1");
                $select_price->execute([$product_id]);
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

                // Insertion du produit dans le panier
                $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, product_id, price, qty) VALUES(?,?,?,?)");
                $insert_cart->execute([$user_id, $product_id, $fetch_price['price'], $qty]);
                $success_msg[] = 'Product added to cart successfully';
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Coffee - shop page</title>
</head>
<body>
    
<?php  include './components/header.php'; ?>
<div class="main">
<div class="banner">
        <h1>Shop</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / our shop</span>
    </div>
    <section class="products">
        <div class="box-container">
            <?php 
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();

            if($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {

                
            ?>
            <form method="post" class="box">
            <img src="image/<?=$fetch_products['image']; ?>" class="img">
                <div class="button">
                    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                    <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bx bxs-show"></a>
                </div>
                <h3 class="name"><?=$fetch_products['name']; ?></h3>
                <input type="hidden" name="product_id" value="<?=$fetch_products['id']; ?>">
                <div class="flex">
                    <p class="price">price $<?=$fetch_products['price']; ?>/-</p>
                    <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                </div>
                <a href="checkout.php?get_id=<?=$fetch_products['id']; ?>" class="btn">buy now</a>
                
            </form>
            <?php

                }
            }else{
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>
    </section>
    <?php include 'components/footer.php'?>
</div>
<script src="http://cdnjs.Cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php  include './components/alert.php'; ?>
</body>
</html>