<?php
    include '../lib/Session.php';   // include Session file
    Session::init();   // Start our session with init method
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');

    spl_autoload_register(function($class){
        include_once "../classes/".$class.".php";
    });
     
    $ct = new Cart(); // Create Cart Class Object 
    $cmr = new Shipping(); // Create Shipping Class Object 
    $ord = new Order(); // Create Order Class Object 

    //order table
    $orderId = $ord->getId();
    //$row = $orderId->fetch_assoc();
    
    //cart table
    $totalPrice = $ct->totalPrice();
?>
<html>
<style> 
        html {
            font-size: 16px;
        }
        
        body {
            font-size: 16px;
            font-family: 'Courier New', Courier, monospace;
            box-sizing: border-box;
            background-color: #E6E6E6;
            min-height: 100%;
        }
        
        html, body{
            margin: 0px;
            padding: 0px;
            overflow-x: hidden; 
            height: 100%;
        }
        
        h1{
            text-align: center;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to bottom, #0C730C, #072407);
        }
        
        h2{
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to bottom, #0C730C, #072407);
            font-size: 30px;
            margin-bottom: 0;
        }
        
        h3{
            text-align: right;
            margin: auto;
            width: 50%;
        }
        
        h4{
            margin: 0;
            font-size: 25px;
        }
        
        p{
            text-align: justify;
            font-weight: 550;
            font-size: 16px;
            margin: 0;
            padding: 2px;
        }
        
        a{
            text-decoration: none;
            color: #072407;
        }
        a:visited,
        a:hover{
            text-decoration: none;
            color: #072407;
        }
        
        table{
            border-bottom: #000 solid 2px;
        }
        
        th{
            text-align: left;
        }
        
        tr{
            text-align: right;
        }
        
        .email-cart > img{
            height: 150px;
            border-radius: 100px;
        }
        
        .container{
            background-color: #fff;
            margin: 5px 200px;
            padding: 5px 10px;
        }
        
        .email-header{
            border-bottom: #7c7c7c solid 2px;
            height: 80px; 
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        
        .email-logo{
            height: 80px;
            width: auto;
        }
        
        .email-cart{
            display: flex;
            flex-direction: row;
            border: #7c7c7c solid 2px;
            border-radius: 5px;
            padding: 5px 20px;
            margin: 10px 0;
        }
        
        .product-info{
            margin: 10px 0 0 10px;
        }
        
        .post-cart{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin: 0 20px;
        }
        
        .h2-address{
            text-align: left;
            margin: 0;
            font-size: 25px;
        }
        
        footer{
            margin-top: 30px;
            padding: 5px;
            background-color: #000;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        
        footer a{
            color: #fff;
            font-size: 16px;
            margin: auto 0 0;
        }
        
        footer a:visited,
        footer a:hover{
            text-decoration: none;
            color: #fff;
        }
        
        footer img{
            height: 60px;
            width: auto;
        }
    </style>
    <body>
        <main class="container">
            <div class="email-header">
                <a class="email-logo" target="_blank" href="http://cuppee-nz.com/"><img src="/img/cuppee-logo.png" alt="Cuppee logo" class="email-logo"></a>
                <h3>Order number: #<?php echo $row['orderId']; ?></h3>
            </div>
            <h1>Thank you for your purchase</h1>
            <p>&nbsp;This email is to confirm your order at <a target="_blank" href="http://cuppee-nz.com/">cuppee-nz.com</a>. Your order number is #625.<br>
                &nbsp;Your item(s) will be dispatched soon.<br>
                &nbsp;The enviroment appreciates your help. 
            </p>
            <h2>Order Details:</h3>
            <?php
                $getProduct = $ct->getCartProduct();
                while ($result = $getProduct->fetch_assoc()) {
            ?>
            <div class="email-cart">
                <img src="/admin/<?php echo $result['productImg1']; ?>" alt="" alt="">
                <div class="product-info">
                    <h4><?php echo $result['productName'];  ?></h4>
                    <p>Unit price: $<?php echo $result['productPrice']/100;  ?></p>
                    <p>Quatity: <?php echo $result['quantity']; ?></p>
                </div>
            </div>
            <?php }    
                $getAddress = $cmr->getAddress();
                $address = $getAddress->fetch_assoc();
            ?>
            <div class="post-cart">
                <div>
                    <h2 class="h2-address">Address details:</h2>
                    <p><?php echo $address['customerName']; ?></p>
                    <p><?php echo $address['shippingAddress1']." ".$address['shippingAddress2'].", ".$address['shippingSuburb']; ?></p>
                    <p><?php echo $address['shippingCity'].", ".$address['shippingPostcode']; ?></p>
                    <p><?php echo $address['shippingCountry']; ?></p>
                    <?php if ($address['shippingMessage'] != ""){ ?>
                            <p><?php echo $address['shippingMessage']; ?>
                        </p>
                    <?php }?>
                </div>
                <table>
                    <tr>
                        <th>Sub total: </th>
                        <td>$31.98</td>
                    </tr>
                    <tr>
                        <th>Shipping: </th>
                        <td>$0.00</td>
                    </tr>
                    <tr>
                        <th>Total: </th>
                        <td><?php echo "$ ".number_format($totalPrice/100, 2); ?></td>
                    </tr>
                </table>
            </div>
            <footer class="footer">
                <a target="_blank" href="http://cuppee-nz.com/">Visit website</a>
                <img src="/img/cuppee-name.png" alt="Cuppee logo">
                <a target="_blank" href="http://cuppee-nz.com/contact-form">Contact Us</a>
            </footer>
        </main>
    </body> 
</html>