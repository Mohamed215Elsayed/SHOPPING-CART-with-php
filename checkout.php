<?php
include('connect.php');

if (isset($_POST['order_btn'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];

    $cart_query = $conn->query("SELECT * FROM `cart`");
    $price_total = 0;
    $product_name = [];

    if ($cart_query->rowCount() > 0) {
        while ($product_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $product_name[] = $product_item['name'] . ' (' . $product_item['quantity'] . ') ';
            $product_price = number_format($product_item['price'] * $product_item['quantity']);
            $price_total += $product_price;
        }
    }

    $total_product = implode(', ', $product_name);
    $detail_query = $conn->query("INSERT INTO `order`(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$price_total')");

    if ($cart_query && $detail_query) {
        require_once('vendor/autoload.php');
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Mohamed');
        $pdf->SetTitle('Order Confirmation');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->AddPage();
        $pdf->SetFont('times', 'BI', 16);

        ob_start(); // Start output buffering

        echo "
        <div class='order-message-container'>
            <div class='message-container'>
                <h3>Thank you for shopping!</h3>
                <div class='order-detail'>
                    <span>" . $total_product . "</span>
                    <span class='total'> total: $" . $price_total . "/-</span>
                </div>
                <div class='customer-details'>
                    <p>Your name: <span>" . $name . "</span></p>
                    <p>Your number: <span>" . $number . "</span></p>
                    <p>Your email: <span>" . $email . "</span></p>
                    <p>Your address: <span>" . $flat . ", " . $street . ", " . $city . ", " . $state . ", " . $country . " - " . $pin_code . "</span></p>
                    <p>Your payment mode: <span>" . $method . "</span></p>
                    <p>(*Pay when product arrives*)</p>
                </div>
            </div>
        </div>
        ";

        $html = ob_get_clean(); // Retrieve the captured HTML content

        $pdf->writeHTML($html);

        // Set the HTTP header for downloading the PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="order_confirmation.pdf"');

        // Output the PDF
        $pdf->Output('order_confirmation.pdf', 'D');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <!-- ***************** -->
   <?php include 'header.php'; ?>
   <!-- *****start checkout section******* -->
   <div class="container">
      <section class="checkout-form">
         <h1 class="heading">complete your order</h1>
         <form action="" method="post">
            <div class="display-order">
               <?php
               $select_cart = $conn->query("SELECT * FROM `cart`");
               $total = 0;
               $grand_total = 0;
               if ($select_cart->rowCount() > 0) {
                  while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                     $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
                     $grand_total = $total += $total_price;
               ?>
                     <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
               <?php };
               } else {
                  echo "<div class='display-order'><span>your cart is empty!</span></div>";
               }
               ?>
               <span class="grand-total"> grand total : $<?= $grand_total; ?>/- </span>
            </div>
            <div class="flex">

               <div class="inputBox">
                  <span>your name</span>
                  <input type="text" placeholder="enter your name" name="name" required>
               </div>

               <div class="inputBox">
                  <span>your number</span>
                  <input type="number" placeholder="enter your number" name="number" required>
               </div>

               <div class="inputBox">
                  <span>your email</span>
                  <input type="email" placeholder="enter your email" name="email" required>
               </div>

               <div class="inputBox">
                  <span>payment method</span>
                  <select name="method">
                     <option value="cash on delivery" selected>cash on devlivery</option>
                     <option value="credit cart">credit cart</option>
                     <option value="paypal">paypal</option>
                  </select>
               </div>

               <div class="inputBox">
                  <span>address line 1</span>
                  <input type="text" placeholder="e.g. flat no." name="flat" required>
               </div>

               <div class="inputBox">
                  <span>address line 2</span>
                  <input type="text" placeholder="e.g. street name" name="street" required>
               </div>

               <div class="inputBox">
                  <span>city</span>
                  <input type="text" placeholder="e.g. tanta" name="city" required>
               </div>

               <div class="inputBox">
                  <span>state</span>
                  <input type="text" placeholder="e.g. Gharbi" name="state" required>
               </div>

               <div class="inputBox">
                  <span>country</span>
                  <input type="text" placeholder="e.g. Egypt" name="country" required>
               </div>

               <div class="inputBox">
                  <span>pin code</span>
                  <input type="text" placeholder="e.g. 123456" name="pin_code" required>
               </div>

            </div>
            <input type="submit" value="order now" name="order_btn" class="btn">
         </form>
      </section>
   </div>
   <!-- ******end checkout section****** -->
   <script src="js/script.js"></script>
</body>

</html>