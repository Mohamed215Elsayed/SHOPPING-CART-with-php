<header class="header">
    <div class="flex">
    <a href="#" class="logo"><img src="images/food-1.png" alt=""></a>
    <nav class="navbar">
        <a href="admin.php">add products</a>
        <a href="products.php">view products</a>
        <a href="#">view orders</a>
        <a href="#">users</a>
        <a href="#">logout</a>

    </nav>
    <?php
      $select_rows = $conn->query("SELECT * FROM `cart`");
      $row_count = $select_rows->rowCount();
      // $row_count = count($select_rows->fetchAll(PDO::FETCH_ASSOC)); 
    // print_r($row_count);
    ?>
    <a href="cart.php" class="cart">cart <span><?= $row_count; ?></span> </a>
    <div id="menu-btn" class="fas fa-bars"></div>
    </div>
</header>
<audio id="sound1" controls autoplay loop style="display:none">
  <source src="أحب من الأسماء.mp3" type="audio/mpeg">
</audio>