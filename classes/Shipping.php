<?php 
$filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');
?>

 
<?php
class Shipping{
	private $db;
    private $fm;
 
    public function __construct(){
       $this->db   = new Database();
       $this->fm   = new Format();
    }

    public function getAddress(){
        
        $sId = session_id();
        $query = "SELECT * FROM tbl_shipping WHERE sId ='$sId' ";
        $a = $this->db->select($query);
        return $a;
    }

    public function getAddressType(){
        $type = "https://www.addy.co.nz/api/address/2417575?key=51ebb0e0c87640acb03d7663e17307a1";

    }
    
    public function customerRegistration($data){

        $name       =  mysqli_real_escape_string($this->db->link, $data['customerName'] );
        $email      =  mysqli_real_escape_string($this->db->link, $data['customerEmail'] );
        $mobile     =  mysqli_real_escape_string($this->db->link, $data['customerMobile'] );
        $address1   =  mysqli_real_escape_string($this->db->link, $data['shippingAddress1'] );
        $address2   =  mysqli_real_escape_string($this->db->link, $data['shippingAddress2'] );
        $suburb     =  mysqli_real_escape_string($this->db->link, $data['shippingSuburb'] );
        $city       =  mysqli_real_escape_string($this->db->link, $data['shippingCity'] );
        $postcode   =  mysqli_real_escape_string($this->db->link, $data['shippingPostcode'] );
        $country    =  "New Zealand";
        $message    =  mysqli_real_escape_string($this->db->link, $data['shippingMessage'] );
        $sId        =  session_id();

        if ($name == "" || $email == "" || $address1 == "" || $suburb == "" || $city == "" || $postcode == "" ) {
            $msg = "<span class='error'>Field Must Not be empty .</span> ";
                return $msg; // return message 
        } else {
        
                $query = "INSERT INTO tbl_shipping(customerName, customerEmail, customerMobile, shippingAddress1, 
                shippingAddress2, shippingSuburb, shippingCity, shippingPostcode, shippingCountry, shippingMessage, sId ) 
                VALUES ('$name','$email','$mobile','$address1','$address2','$suburb','$city','$postcode','$country','$message', '$sId')
                ON DUPLICATE KEY UPDATE
                customerName 	    = '$name',
                customerEmail       = '$email',
                customerMobile      = '$mobile',
                shippingAddress1 	= '$address1',
                shippingAddress2 	= '$address2',
                shippingSuburb  	= '$suburb',
                shippingCity        = '$city',
                shippingPostcode 	= '$postcode',
                shippingCountry 	= '$country',
                shippingMessage 	= '$message'";
            $update_data = $this->db->insert($query);
            if ($update_data) {
                header("Location:payment");
            }
        } 
    }
}