<header class="header">
    <div class="flex">
    <a href="#" class="logo"><img src="images/food-1.png" alt=""></a>
    <nav class="navbar">
        <a href="admin.php">add products</a>
        <a href="products.php">view products</a>
    </nav>
    <?php
      $select_rows = $conn->query("SELECT * FROM `cart`");
      $row_count = $select_rows->rowCount();
    //   $row_count =count($select_rows->fetchAll(PDO::FETCH_ASSOC));
    ?>
    <a href="cart.php" class="cart">cart <span><?= $row_count; ?></span> </a>
    <div id="menu-btn" class="fas fa-bars"></div>
    </div>
</header>