<?php 
include('connect.php');
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_image = $_FILES['product_image']['name'];
$product_image_tmp_name = $_FILES['product_image']['tmp_name'];
$product_image_folder = 'uploaded_img/'.$product_image;
if(empty($product_name) || empty($product_price) || empty($product_image)){
    $message[] = 'please fill out all!';    
}
else{
    $update_data = "UPDATE `products` SET name='$product_name', price='$product_price', image='$product_image'  WHERE id = '$id'";
    $upload = $conn->query($update_data);
    if($upload){
        move_uploaded_file($product_image_tmp_name, $product_image_folder);
        header('location:admin_page.php');
    }
    
    else{
        $$message[] = 'please fill out all!'; 
    }
}
