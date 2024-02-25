<?php
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ************************** -->
    <?php
    if (isset($_POST['add_product'])) {
        $p_name = $_POST['p_name'];
        $p_price = $_POST['p_price'];
        $p_image = $_FILES['p_image']['name'];
        $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
        $p_image_folder = 'uploaded_img/' . $p_image;
        $insert_query = $conn->query("INSERT INTO `products`(name, price, image) VALUES('$p_name', '$p_price', '$p_image')");
        if ($insert_query) {
            move_uploaded_file($p_image_tmp_name, $p_image_folder);
            $message[] = 'product is added succesfully';
        } else {
            $message[] = 'could not add the product';
        }
    }
    ?>
    <!-- ************************ -->
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
        };
    };
    ?>
    <!-- ************************** -->
    <?php
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $delete_query = $conn->query("DELETE FROM `products` WHERE id = $delete_id ");
        if ($delete_query) {
            header('location:admin.php');
            $message[] = 'product has been deleted';
        } else {
            header('location:admin.php');
            $message[] = 'product could not be deleted';
        };
    };
    ?>
    <!-- *************************** -->
    <?php
    if (isset($_POST['update_product'])) {
        $update_p_id = $_POST['update_p_id'];
        $update_p_name = $_POST['update_p_name'];
        $update_p_price = $_POST['update_p_price'];
        $update_p_image = $_FILES['update_p_image']['name'];
        $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
        $update_p_image_folder = 'uploaded_img/' . $update_p_image;
        $update_query = $conn->query("UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");
        if ($update_query) {
            move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
            $message[] = 'product is updated succesfully';
            header('location:admin.php');
        } else {
            $message[] = 'could not update the product';
            header('location:admin.php');
        }
    }
    ?>
    <!-- *************************** -->
    <?php include 'header.php'; ?>
    <!-- ************************** -->
    <div class="container">
        <section>
            <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
                <h3>add a new product</h3>
                <input type="text" name="p_name" placeholder="enter the product name" class="box" required>
                <input type="number" name="p_price" min="0" placeholder="enter the product price" class="box" required>
                <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
                <input type="submit" value="add the product" name="add_product" class="btn">
            </form>
        </section>
        <section class="display-product-table">
            <table>
                <thead>
                    <th>product image</th>
                    <th>product name</th>
                    <th>product price</th>
                    <th>action</th>
                </thead>
                <tbody>
                    <?php
                    $select_products = $conn->query("SELECT * FROM `products`");
                    if ($select_products->rowCount() > 0) {
                        $products = $select_products->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($products as $product) { ?>
                            <tr>
                                <td><img src="uploaded_img/<?= $product['image'] ?>" height="100" alt=""></td>
                                <td><?= $product['name'] ?></td>
                                <td>$<?= $product['price']; ?>/-</td>
                                <td><a href="admin.php?delete=<?= $product['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
                                    <a href="admin.php?edit=<?= $product['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
                                </td>
                            </tr>
                    <?php
                        };
                    } else {
                        echo "<div class='empty'>no product added</div>";
                    };
                    ?>
                </tbody>
            </table>
        </section>
        <section class="edit-form-container">
            <?php
            if (isset($_GET['edit'])) {
                $edit_id = $_GET['edit'];
                $edit_query = $conn->query("SELECT * FROM `products` WHERE id = $edit_id");
                if ($edit_query->rowCount() > 0) {
                    $fetch_edit = $edit_query->fetch(PDO::FETCH_ASSOC);
            ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <img src="uploaded_img/<?= $fetch_edit['image']; ?>" height="200" alt="">
                        <input type="hidden" name="update_p_id" value="<?= $fetch_edit['id']; ?>">
                        <input type="text" class="box" required name="update_p_name" value="<?= $fetch_edit['name']; ?>">
                        <input type="number" min="0" class="box" required name="update_p_price" value="<?= $fetch_edit['price']; ?>">
                        <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
                        <input type="submit" value="update the product" name="update_product" class="btn">
                        <input type="reset" value="cancel" id="close-edit" class="option-btn">
                    </form>
            <?php
                    echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
                }
            }
            ?>
        </section>
    </div>
    <!-- ************************** -->
    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>

</html>