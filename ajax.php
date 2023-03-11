<?php
$conn = mysqli_connect("localhost", "root", "", "invoice");
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
  else {
    if (isset($_POST['item_name'])) {
        $name = $_POST['item_name']; 
        $quantity = $_POST['quantity']; 
        $price = $_POST['unit_price']; 
        $tax = $_POST['tax']; 

        $total_with_tax =( $quantity * $price * $tax )/100;
        $total_without_tax =( $quantity * $price );
        $total_with_tax = $total_without_tax + $total_with_tax;
    
        $sql = "INSERT INTO items (item_name, item_quantity, unit_price, tax, total_with_tax, total_without_tax) VALUES ('$name', $quantity, $price, $tax, $total_with_tax, $total_without_tax);";
    
        if(mysqli_query($conn, $sql)){
            echo json_encode(array('success' => 1,'item'=> $sql));
        } else {
        echo json_encode(array('success' => 0));
    }  
        
    }
  }



?>