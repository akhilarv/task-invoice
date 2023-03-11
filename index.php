<?php

$conn = mysqli_connect("localhost", "root", "", "invoice");
 
//Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Invoice</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/bootstrap.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src= "https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js">
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>


</head>

<body>
    <div id="invoice">

<section class="container-fluid" style="padding-top:100px;padding-bottom:100px;text-align:center;">
    <h1>Generate Invoice</h1>
</section>

<section class="container add-invoice">
    <form id="addItem" method="post">        
    <div class="row">
            <div class="col-md-2">
                <input type="text" id="item_name" name="item_name" placeholder="ITEM NAME">
            </div>
            <div class="col-md-2">
                <input type="text" id="quantity" name="quantity" placeholder="QUANTITY">
            </div>
            <div class="col-md-2">
                <input type="text" id="unit_price" name="unit_price" placeholder="UNIT PRICE">
            </div>
            <div class="col-md-2">
                <select name="tax" id="tax">
                    <option value="">SELECT TAX</option>
                    <option value="0">0%</option>
                    <option value="1">1%</option>
                    <option value="5">5%</option>
                    <option value="10">10%</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="submit" id="add_item" name="add_item" value="add_item">
            </div>
            <div class="col-md-2">
                <span class="total"></span>
            </div>
</div>
</form>
</section>

<section class="display-items container">
    <table>
        <tr>
            <th>name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>tax</th>
            <th>Total without tax</th>
            <th>Total with tax</th>
        </tr>

        <?php
        $sql = "SELECT * FROM items";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) { 
            $total_no_tax=0; $total_inc_tax=0;
          // output data of each row
          while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['item_name'] ?></td>
                <td><?php echo $row['item_quantity'] ?></td>
                <td><?php echo $row['unit_price'] ?></td>
                <td><?php echo $row['tax'] ?>%</td>
                <td><?php echo $row['total_without_tax'] ?></td>
                <td><?php echo $row['total_with_tax'] ?></td>
            </tr>
         <?php $total_no_tax = $total_no_tax + $row['total_without_tax'] ;
             $total_inc_tax  = $total_inc_tax + $row['total_with_tax'] ;
        } ?>
         <tr class="total">
            <td></td>
            <td></td>
            <td></td>
            <td>Sub Total</td>
            <td><input type="hidden" id="total_no_tax" name="total_no_tax" value="<?php echo $total_no_tax; ?>"><?php echo $total_no_tax; ?></td>
            <td><input type="hidden" id="total_inc_tax" name="total_inc_tax" value="<?php echo $total_inc_tax; ?>"><?php echo $total_inc_tax; ?></td>
         </tr>  
         <tr class="total">
            <td></td>
            <td></td>
            <td></td>
            <td>Discount</td>
            <td><input type="number" id="discount" name="discount" placeholder="DISCOUNT (%)"></td>
            <td><input type="button" id="add_discount" name="add_discount" value="add_discount"></td>
         </tr>
         <tr class="total">
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td colspan="2" id="total_amount"><?php echo $total_inc_tax; ?></td>
         
            <td></td> </tr>   
         <?php } ?>
        
    </table>

    <input type="button" id="generate_invoice" name="generate_invoice" value="GENERATE INVOICE">

    

</section>
</div>
</body>
</html>