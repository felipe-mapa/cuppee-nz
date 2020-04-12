<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');
?>
 
<?php
class Cart{
	private $db;
	private $fm;
 
    public function __construct(){
       $this->db   = new Database();
       $this->fm   = new Format();
    }
    
    public function addToCart($quantity, $productId){
        $quantity = $this->fm->validation($quantity);  // add Format Class validation 
        $quantity =  mysqli_real_escape_string($this->db->link, $quantity); // for $quantity filed 
        $productId =  mysqli_real_escape_string($this->db->link, $productId);  // for $id filed 
        $sId = session_id();
        
        $squery = "SELECT * FROM tbl_product WHERE productId = '$productId'";
        $result = $this->db->select($squery)->fetch_assoc();
     
        $productName = $result['productName'];
        $productPrice = $result['productPrice'];
        $productImg1 = $result['productImg1'];

        // Take this variable as $chquery and put select query.
        $chquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId ='$sId'";
        $getProduct = $this->db->select($chquery);
        if (!$getProduct) {
            $query = "INSERT INTO tbl_cart(sId, productId, productName, productPrice, quantity, productImg1) 
            VALUES ('$sId','$productId','$productName','$productPrice','$quantity','$productImg1')";  

            $inserted_row = $this->db->insert($query); 
            if ($inserted_row) {
                header("Location:cart.php");
            }
        }else {
            $msg = "Product Already Added!";
            return $msg;
        
        } 
    }


    public function getCartProduct(){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId ='$sId' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateCartQuantity($cartId, $quantity){
        $cartId =  mysqli_real_escape_string($this->db->link, $cartId ); 
        $quantity =  mysqli_real_escape_string($this->db->link, $quantity );
  
        $query = "UPDATE tbl_cart
                 SET
                 quantity = '$quantity'
                 WHERE cartId = '$cartId' ";
                 $update_row  = $this->db->update($query);
                 if ($update_row) {
                    header("Location:cart.php");
                      $msg = "<span class='success'> Quantity updated successfullly.</span>";
                      return $msg;
                 }else {
                     $msg = "<span class='error'>Quantity Not Updated .</span> ";
                     return $msg; 
                 } 
   }




   public function delProductByCart($delId) {
    $delId =  mysqli_real_escape_string($this->db->link, $delId ); 
    $query = "DELETE FROM tbl_cart WHERE cartId ='$delId' ";
             $deldata = $this->db->delete($query);
             if ($deldata) {
                 echo "<script>window.location = 'cart.php';</script> ";
              }else {
                 $msg = "<span class='error'>Product Not Deleted .</span> ";
                    return $msg; // return this message 
                 }
    }

    public function countQuantity(){
        $sId = session_id();
        $query = "SELECT SUM(quantity) AS sum FROM tbl_cart WHERE sId ='$sId' ";
        $quantityInCart = $this->db->select($query);
        $val = $quantityInCart->fetch_array();
        $total = $val['sum'];
        return $total;
    }

    public function checkCartTable(){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId ='$sId' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function totalPrice(){
        $sId = session_id();
        $queryTotal = "SELECT SUM(quantity*productPrice) AS total FROM tbl_cart WHERE sId ='$sId' ";
        $totalPrice = $this->db->select($queryTotal);
        $val = $totalPrice->fetch_array();
        $total = $val['total'];
        return $total;
    }
}