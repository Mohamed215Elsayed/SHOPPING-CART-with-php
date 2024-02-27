<?php
require_once('vendor/autoload.php');

// Create new PDF document
// $pdf = new TCPDF();
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

$html = "
<div class='order-message-container'>
   <div class='message-container'>
      <h3>thank you for shopping!</h3>
      <div class='order-detail'>
         <span>" . $total_product . "</span>
         <span class='total'> total : $" . $price_total . "/-  </span>
      </div>
      <div class='customer-details'>
         <p> your name : <span>" . $name . "</span> </p>
         <p> your number : <span>" . $number . "</span> </p>
         <p> your email : <span>" . $email . "</span> </p>
         <p> your address : <span>" . $flat . ", " . $street . ", " . $city . ", " . $state . ", " . $country . " - " . $pin_code . "</span> </p>
         <p> your payment mode : <span>" . $method . "</span> </p>
         <p>(*pay when product arrives*)</p>
      </div>
      <a href='products.php' class='btn'>continue shopping</a>
      <a href='cart.php' class='btn'>go to cart</a>
   </div>
</div>
";

$pdf->writeHTML($html);

// Close and output PDF document
// $pdf->Output('example.pdf', 'I');
$pdf->Output('order_confirmation.pdf', 'I');
// $pdf->Output('/path/to/order_confirmation.pdf', 'F');