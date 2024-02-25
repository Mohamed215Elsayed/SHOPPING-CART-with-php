<!-- connect.php -->
<?php
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ************** -->
    <?php
    if (isset($_POST['add_to_cart'])) {
        $product_name = htmlspecialchars($_POST['product_name']);
        $product_price = htmlspecialchars($_POST['product_price']);
        $product_image = htmlspecialchars($_POST['product_image']);
        $product_quantity = 1;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE name = :product_name");
        $select_cart->execute(array(':product_name' => $product_name));
        // Check the result using rowCount() method
        if ($select_cart->rowCount() > 0) {
            $message[] = 'product already added to cart';
        } else {
            // Prepare and execute the INSERT query using PDO
            $insert_product = $conn->prepare("INSERT INTO `cart` (name, price, image, quantity) VALUES (:product_name, :product_price, :product_image, :product_quantity)");
            $insert_product->execute(array(
                ':product_name' => $product_name,
                ':product_price' => $product_price,
                ':product_image' => $product_image,
                ':product_quantity' => $product_quantity
            ));
            $message[] = 'product added to cart successfully';
        }
    }
    ?>
    <!-- ************** -->
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
        };
    };
    ?>
    <!-- ************** -->
    <?php include('header.php'); ?>
    <div class="container">
        <section class="products">
            <h1 class="heading">latest products</h1>
            <div class="box-container">
                <?php
                $select_products = $conn->query("SELECT * FROM `products`");
                if ($select_products->rowCount() > 0) {
                    $products = $select_products->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($products as $product) { ?>
                        <form action="" method="post">
                            <div class="box">
                                <img src="uploaded_img/<?=  $product['image']; ?>" alt="">
                                <h3><?= $product['name']; ?></h3>
                                <div class="price">$<?= $product['price']; ?>/-</div>
                                <input type="hidden" name="product_name" value="<?= $product['name']; ?>">
                                <input type="hidden" name="product_price" value="<?= $product['price']; ?>">
                                <input type="hidden" name="product_image" value="<?= $product['image']; ?>">
                                <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                            </div>
                        </form>
                <?php   };
                };
                ?>
            </div>
        </section>
    </div>
    <!-- ************** -->
    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>

</html>