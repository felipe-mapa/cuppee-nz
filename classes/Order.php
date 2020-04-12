<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');

    spl_autoload_register(function($class){
        include_once $class.".php";
    });
?>

 
<?php
class Order{
	private $db;
	private $fm;
 
    public function __construct(){
       $this->db   = new Database();
       $this->fm   = new Format();
    }

    public function getOrder(){
        $ct = new Cart(); // Create Cart Class Object 
        $sId =  session_id();
        $totalPrice = $ct->totalPrice();
        
        $query = "INSERT INTO tbl_order(sId, totalPrice) 
        VALUES ('$sId', '$totalPrice')
        ON DUPLICATE KEY UPDATE
        totalPrice 	= '$totalPrice'";
        $update_data = $this->db->insert($query);
        if($update_data){
            
            // send order to cuppee email
            $this->emailOrder();
                        
            //send invoice
            $this->emailInvoice();

            //end session
            session_regenerate_id(true);
            
            //OPEN SUCCESS
            header("Location:success");
        }
    }

    public function getId(){
        $sId = session_id();
        $query = "SELECT orderId FROM tbl_order WHERE sId ='$sId' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function emailOrder(){
        //order table
        
        //cart table
        $ct = new Cart(); // Create Cart Class Object 
        $cmr = new Shipping(); // Create Shipping Class Object 
        $totalPrice = $ct->totalPrice();

        # Sender Data
        $mail_to = "info@cuppee-nz.com";
        $subject = "New Cuppee purchase";
        
        # email headers.
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        // Additional headers
        $headers .= 'From: Cuppee - Foldable Cup <info@cuppee-nz.com>';
        $headers .= "Reply-To: info@cuppee-nz.com";
        

        # content
        $content = '<html><body
            style="font-size: 16px;
            box-sizing: border-box;
            background-color: #E6E6E6;
            min-height: 100%;
            margin: 0px auto;
            padding: 0px;
            overflow-x: hidden; 
            height: 100%;
            width: 100%;
            max-width:600px;">';
        $content .= '<main style="
                            background-color: #fff;
                            margin: 5px auto;
                            padding: 5px 10px;
                            max-width: 600px;">';
        $content .= '<div style="
                            border-bottom: #7c7c7c solid 2px;
                            height: 80px; 
                            display:-webkit-flex;
                            display:-ms-flexbox;
                            display:flex;
                            flex-direction: -ms-row;
                            justify-content: -ms-space-between;" >';
        $content .= '<a target="_blank" href="http://cuppee-nz.com/" style="
                            height: 80px;
                            width: auto;
                            text-decoration: none;
                            color: #0C730C;">
                            <img src="http://felipepavanela78601.ipage.com/cuppee/img/cuppee-logo.png" alt="Cuppee logo" style="height: 80px;
                            width: auto;"></a>';
        $orderId = $this->getId();
        $row = $orderId->fetch_assoc();
        $content .= '<h3 style="
                    text-align: right;
                    margin: auto;
                    width: 50%;">
                    Order number: #'.$row['orderId'].'</h3></div>';
        $content .= '<h1 style="
                    text-align: center;
                    color: #0C730C;">
                    Cuppee - New purchase</h1>';
        $getAddress = $cmr->getAddress();
        $address = $getAddress->fetch_assoc();
        $content .= '<div style="padding: 0 10px;"><h2 style="
                    color: #0C730C;
                    text-align: left;
                    margin: 0;
                    font-size: 25px;">
                    Customer information:</h2>';
        $content .= '<p style="text-align: justify;
                    font-weight: 550;
                    font-size: 16px;
                    margin: 0;
                    padding: 2px;">'.$address['customerName'].'</p>';
        $content .= '<p style="text-align: justify;
                    font-weight: 550;
                    font-size: 16px;
                    margin: 0;
                    padding: 2px;
                    text-decoration:none;">'.$address['customerEmail'].'</p>';
        if ($address['customerMobile'] != "0"){
                    $content .= '<p style="text-align: justify;
                    font-weight: 550;
                    font-size: 16px;
                    margin: 0;
                    padding: 2px;">'.$address['customerMobile'].'</p>';
        }
        $content .= '<p style="text-align: justify;
                    font-weight: 550;
                    font-size: 16px;
                    margin: 0;
                    padding: 2px;">'.$address['shippingAddress1']." ".$address['shippingAddress2'].", ".$address['shippingSuburb'].'</p>';
        $content .= '<p style="text-align: justify;
                    font-weight: 550;
                    font-size: 16px;
                    margin: 0;
                    padding: 2px;">'.$address['shippingCity'].", ".$address['shippingPostcode'].'</p>';
        $content .= '<p style="text-align: justify;
                    font-weight: 550;
                    font-size: 16px;
                    margin: 0;
                    padding: 2px;">'.$address['shippingCountry'].'</p>';
        if ($address['shippingMessage'] != ""){
            $content .= '<p style="text-align: justify;
                        font-weight: 550;
                        font-size: 16px;
                        margin: 0;
                        padding: 2px;">'.$address['shippingMessage'].'</p>';
        }
        $content .="</div>";
        $content .= '<h2 style="
                        padding: 0 10px;
                        color: #0C730C;
                        font-size: 30px;
                        margin-bottom: 0;">
                        Order Details:</h2>';
        $getProduct = $ct->getCartProduct();
        while ($result = $getProduct->fetch_assoc()) {
            $content .= '<div style="
                            display:flex;
                            border: #7c7c7c solid 2px;
                            border-radius: 5px;
                            padding: 5px 20px;
                            margin: 10px;">';
            $content .= '<img src="http://felipepavanela78601.ipage.com/cuppee/admin/'.$result['productImg1'].'" style="height: 150px;
                        border-radius: 100px;">';
            $content .= '<div style="margin: 10px 0 0 10px;">';
            $content .= '<h4 style="
                                    margin: 0;
                                    font-size: 25px;
                                    ">'.$result['productName'].'</h4>';
            $content .= '<p style="text-align: justify;
                        font-weight: 550;
                        font-size: 16px;
                        margin: 0;
                        padding: 2px;">Unit price: $'.($result['productPrice']/100).'</p>';
            $content .= '<p style="text-align: justify;
                        font-weight: 550;
                        font-size: 16px;
                        margin: 0;
                        padding: 2px;">Quantity: '.$result['quantity'].'</p></div></div>';
        }  
        $content .= '<table style="border-bottom: #000 solid 2px;
                margin: 0 10px 0 auto"><tr style="text-align: right;">';
        $content .= '<th style="text-align: left;">Sub total: </th>
                <td> $'.(number_format($totalPrice/100, 2)).'</td>';
        $content .= '</tr><tr style="text-align: right;">';
        $content .= '<th style="text-align: left;">Shipping: </th>
                <td>$0.00</td>';
        $content .= '</tr><tr style="text-align: right;">';
        $content .= '<th style="text-align: left;">Total: </th>
                <td>$'.number_format($totalPrice/100, 2).'</td>
                </tr></table>';
        $content .= '<div style="
                    margin-top: 30px;
                    padding: 5px 10px;
                    background-color: #000;
                    display:flex;">';
        $content .= '<a style="
                    color: #fff;
                    font-size: 16px;
                    margin: auto auto auto 0;
                    text-decoration: none;" target="_blank" href="http://cuppee-nz.com/">Visit website</a>';
        $content .= '<img src="http://felipepavanela78601.ipage.com/cuppee/img/cuppee-name.png" alt="Cuppee logo" style="
                    height: 60px;
                    width: auto;">';
        $content .= '<a style="
                    color: #fff;
                    font-size: 16px;
                    margin: auto 0 auto auto;
                    text-decoration: none;" target="_blank" href="http://cuppee-nz.com/contact-form">Contact Us</a>';
        $content .= '</div></main></body></html>';



        # Send the email.
        $success = mail($mail_to, $subject, $content, $headers);
    }


    public function emailInvoice(){
        //cart table
        $ct = new Cart(); // Create Cart Class Object 
        $cmr = new Shipping(); // Create Shipping Class Object 
        $totalPrice = $ct->totalPrice();
        $orderId = $this->getId();
        $row = $orderId->fetch_assoc();

        # Sender Data
        $getAddress = $cmr->getAddress();
        $address = $getAddress->fetch_assoc();

        $mail_to = $address['customerEmail'];
        $subject = "Cuppee - Order #".$row['orderId'];

        # email headers.
        $headers  = "From: Cuppee - Foldable Cup <info@cuppee-nz.com>\n";
        $headers .= "X-Sender: Cuppee <info@cuppee-nz.com>\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        $headers .= "X-Priority: 1\n"; // Urgent message!
        $headers .= "Return-Path: info@cuppee-nz.com\n"; // Return path for errors
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
        
        # Mail Content
        $content = '<html><body style="
            font-size: 16px;
            box-sizing: border-box;
            background-color: #E6E6E6;
            margin: 0px auto;
            padding: 0px;
            max-width: 600px;
            overflow-x: hidden; 
            height: 100%;">';
        $content .= '<main style="
            background-color: #fff;
            margin: 5px auto;
            padding: 5px 10px;
            width: 600px;">';
        $content .= '<div style="
            border-bottom: #7c7c7c solid 2px;
            height: 80px; 
            display:-webkit-flex;
                            display:-ms-flexbox;
                            display:flex;
            flex-direction: -ms-row;
            justify-content: -ms-space-between;">';
        $content .= '<a target="_blank" href="http://cuppee-nz.com/" style="
            height: 80px;
            width: auto;">';
        $content .= '<img src="http://felipepavanela78601.ipage.com/cuppee/img/cuppee-logo.png" alt="Cuppee logo" style="
            height: 80px;
            width: auto;"></a>';
        $content .= '<h3 style="
            text-align: right;
            margin: auto;
            width: 50%;">Order number: #'.$row['orderId'].'</h3></div>';
        $content .= '<h1 style="
            text-align: center;
            color:#0C730C;">Thank you for your purchase</h1>';
        $content .= '<p style="
            text-align: justify;
            font-weight: 550;
            font-size: 16px;
            margin: 0;
            padding: 0 20px;">&nbsp;&nbsp;&nbsp;This email is to confirm your order at <a style="
            text-decoration: none;
            color: #0C730C;" target="_blank" href="http://cuppee-nz.com/">cuppee-nz.com</a>. Your order number is '.$row['orderId'].'.<br>
            &nbsp;&nbsp;&nbsp;Your item(s) will be dispatched soon.</br>
            &nbsp;The enviroment appreciates your help.</p>';
        $getAddress = $cmr->getAddress();
        $address = $getAddress->fetch_assoc();
        $content .= '<h2 style="
            color:#0C730C;
            font-size: 30px;
            margin-bottom: 0;
            padding: 0 20px;">Order Details:</h2>';

        $getProduct = $ct->getCartProduct();
        while ($result = $getProduct->fetch_assoc()) {
            $content .= '<div style="
                display:-webkit-flex;
                display:-ms-flexbox;
                display:flex;
                flex-direction: -ms-row;
                border: #7c7c7c solid 2px;
                border-radius: 5px;
                padding: 5px 20px;
                margin: 10px 20px;">';
            $content .= '<img src="http://felipepavanela78601.ipage.com/cuppee/admin/'.$result['productImg1'].'" style="
                height: 150px;
                border-radius: 100px;">';
            $content .= '<div style="margin: 10px 0 0 10px;">';
            $content .= '<h4 style="
                margin: 0;
                font-size: 25px;">'.$result['productName'].'</h4>';
            $content .= '<p style="
                text-align: justify;
                font-weight: 550;
                font-size: 16px;
                margin: 0;
                padding: 2px;">Unit price: $'.($result['productPrice']/100).'</p>';
            $content .= '<p style="
                text-align: justify;
                font-weight: 550;
                font-size: 16px;
                margin: 0;
                padding: 2px;">Quatity: '.$result['quantity'].'</p></div></div>';
        }
        $getAddress = $cmr->getAddress();
        $address = $getAddress->fetch_assoc();
        $content .= '<h2  style="
        color:#0C730C;
        text-align: left;
        padding: 0px 20px;
        margin: 0;
        font-size: 25px;">Address details:</h2>';
        $content .= '<div style="
                display:flex;;
                margin: 0 20px;">';
        $content .= '<div><p style="
            text-align: justify;
            font-weight: 550;
            font-size: 16px;
            margin: 0;
            padding: 2px;">'.$address['customerName'].'</p>';
        $content .= '<p style="
            text-align: justify;
            font-weight: 550;
            font-size: 16px;
            margin: 0;
            padding: 2px;">'.$address['shippingAddress1']." ".$address['shippingAddress2'].", ".$address['shippingSuburb'].'</p>';
        $content .= '<p style="
            text-align: justify;
            font-weight: 550;
            font-size: 16px;
            margin: 0;
            padding: 2px;">'.$address['shippingCity'].", ".$address['shippingPostcode'].'</p>';
        $content .= '<p style="
            text-align: justify;
            font-weight: 550;
            font-size: 16px;
            margin: 0;
            padding: 2px;">'.$address['shippingCountry'].'</p>';
        if ($address['shippingMessage'] != ""){
            $content .= '<p style="
                text-align: justify;
                font-weight: 550;
                font-size: 16px;
                margin: 0;
                padding: 2px;">'.$address['shippingMessage'].'</p></div>';
        }
        $content .= '</div><table style="border-bottom: #000 solid 2px; margin:0 0 0 auto;">';
        $content .= '<tr style="text-align: right;">';
        $content .= '<th style="text-align: left;">Sub total: </th>';
        $content .= '<td>$'.(number_format($totalPrice/100, 2)).'</td></tr>';
        $content .= '<tr style="text-align: right;">';
        $content .= '<th style="text-align: left;">Shipping: </th>';
        $content .= '<td>$0.00</td></tr>';
        $content .= '<tr style="text-align: right;">';
        $content .= '<th style="text-align: left;">Total: </th>';
        $content .= '<td>$'.(number_format($totalPrice/100, 2)).'</td></tr></table></div>';

        $content .= '<div style="
            margin-top: 30px;
            padding: 5px;
            background-color: #000;">';
        $content .= '<a style="
            color: #fff;
            font-size: 16px;
            margin: auto auto auto 0;
            text-decoration: none;" target="_blank" href="http://cuppee-nz.com/">Visit website</a>';
        $content .= '<img src="http://felipepavanela78601.ipage.com/cuppee/img/cuppee-name.png" alt="Cuppee logo" style="
            height: 60px;
            width: auto;
            margin: 0 135px;">';
        $content .= '<a style="
            color: #fff;
            font-size: 16px;
            margin: auto 0 auto auto;
            text-decoration: none;" target="_blank" href="http://cuppee-nz.com/contact-form">Contact Us</a>';
        $content .= '</div></main></body></html>';

        # Send the email.
        $success = mail($mail_to, $subject, $content, $headers);
    }
}