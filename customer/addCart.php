<?php 
session_start();

if($_POST['add_cart']){
if(isset($_SESSION['cart']))
{   $id = $_POST['id'];
    $qty = $_POST['qty'];
    if(array_key_exists($id, $_SESSION['cart']))
    {
         $_SESSION['cart'][$id] = $qty;
    }
    else{
        
        $_SESSION['cart'][$id] = $qty;
    }
}
else{//
      $_SESSION['cart']= [];
      $_SESSION['cart'][$id] = $qty;


}}
foreach($_SESSION['cart'] as $id=>$qty)
{
    echo "$id<br>$qty";
}



?>