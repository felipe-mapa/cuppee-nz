<?php 
 $filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 ?>

<?php
 
class Product{
	private $db;
	private $fm;
 
    public	function __construct(){
        $this->db   = new Database();
        $this->fm   = new Format(); 
    }
 
    public function productInsert($data, $file){
 
        $productName   =  mysqli_real_escape_string($this->db->link, $data['productName'] );
        $sizeId 	   =  mysqli_real_escape_string($this->db->link, $data['sizeId'] );
        $colorId 	   =  mysqli_real_escape_string($this->db->link, $data['colorId'] );
        $productPrice  =  mysqli_real_escape_string($this->db->link, $data['productPrice'] );
    
        $permited = array('jpg','png','jpeg','gif');
        $file_name1 = $file['productImg1']['name'];
        $file_size1 = $file['productImg1']['size'];
        $file_temp1 = $file['productImg1']['tmp_name'];

        $file_name2 = $file['productImg2']['name'];
        $file_size2 = $file['productImg2']['size'];
        $file_temp2 = $file['productImg2']['tmp_name'];

        $div1 = explode('.', $file_name1);
        $div2 = explode('.', $file_name2);
        $file_ext1 = strtolower(end($div1));
        $file_ext2 = strtolower(end($div2));
        $unique_image1 = substr(md5(time()), 0, 10).'.'.$file_ext1;
        $unique_image2 = substr(md5(time()), 0, 5).'.'.$file_ext2;
        $uploaded_image1 = "upload/".$unique_image1;
        $uploaded_image2 = "upload/".$unique_image2;
        
        if ($productName == "" || $sizeId == "" || $colorId == "" || $productPrice == "" ) {
            $msg = "<span class='error'>Field Must Not be empty .</span> ";
            return $msg;
        }
        else{
            move_uploaded_file($file_temp1, $uploaded_image1);
            move_uploaded_file($file_temp2, $uploaded_image2);
            $query = "INSERT INTO tbl_product(productName, sizeId, colorId, productPrice, productImg1, productImg2) 
            VALUES ('$productName','$sizeId','$colorId','$productPrice','$uploaded_image1','$uploaded_image2')";  

            $inserted_row = $this->db->insert($query);

            if ($inserted_row) {
                $msg = "<span class='success'>Product Inserted Successfully.</span> ";
                return $msg; // return message 
            }else {
                $msg = "<span class='error'>Product Not Inserted .</span> ";
                return $msg; // return message 
            } 
        }

    } // Total Method end

    public function getAllProduct(){
        $query = " SELECT tbl_product.*, tbl_size.sizeName, tbl_color.colorName, tbl_soldOut.soldOut
                    FROM tbl_product
                    INNER JOIN tbl_size
                    ON tbl_product.sizeId = tbl_size.sizeId
                    INNER JOIN tbl_color
                    ON tbl_product.colorId = tbl_color.colorId
                    INNER JOIN tbl_soldOut
                    ON tbl_product.soldOutId = tbl_soldOut.soldOutId
                    ORDER BY tbl_product.productId DESC";
        $result =  $this->db->select($query);
        return $result; 
    }

    public function getProById($id){
        $query = "SELECT * FROM tbl_product WHERE productId ='$id' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function productUpdate($data, $file, $id){
 
        $productName     =  mysqli_real_escape_string($this->db->link, $data['productName'] );
        $sizeId 	     =  mysqli_real_escape_string($this->db->link, $data['sizeId'] );
        $colorId 	     =  mysqli_real_escape_string($this->db->link, $data['colorId'] );
        $productPrice  	 =  mysqli_real_escape_string($this->db->link, $data['productPrice'] );
        $soldOutId  	 =  mysqli_real_escape_string($this->db->link, $data['soldOutId'] );
     
        $permited = array('jpg','png','jpeg','gif');
        $file_name1 = $file['productImg1']['name'];
        $file_size1 = $file['productImg1']['size'];
        $file_temp1 = $file['productImg1']['tmp_name'];

        $file_name2 = $file['productImg2']['name'];
        $file_size2 = $file['productImg2']['size'];
        $file_temp2 = $file['productImg2']['tmp_name'];

        $div1 = explode('.', $file_name1);
        $div2 = explode('.', $file_name2);
        $file_ext1 = strtolower(end($div1));
        $file_ext2 = strtolower(end($div2));
        $unique_image1 = substr(md5(time()), 0, 10).'.'.$file_ext1;
        $unique_image2 = substr(md5(time()), 0, 5).'.'.$file_ext2;
        $uploaded_image1 = "upload/".$unique_image1;
        $uploaded_image2 = "upload/".$unique_image2;
         if ($productName == "" || $sizeId == "" || $colorId == "" || $productPrice == "" ) {
             $msg = "<span class='error'>Field Must Not be empty .</span> ";
                    return $msg;
         }else {
         if (!empty($file_name1) || !empty($file_name2)) {
            if (($file_size1 || $file_size2) > 1054589) {
             echo "<span class='error'>Image Size should be less then 1MB .</span>";
            }elseif (in_array($file_ext, $permited) === false) {
             echo "<span class='error'> You can Upload Only".implode(',', $permited)."</span>";
            } else{
              move_uploaded_file($file_temp1, $uploaded_image1);
              move_uploaded_file($file_temp2, $uploaded_image2);
              $query = "UPDATE tbl_product
              SET 
              productName 	= '$productName',
              sizeId 		= '$sizeId',
              colorId 		= '$colorId',
              productPrice 	= '$productPrice',
              productImg1 	= '$uploaded_image1',
              productImg2 	= '$uploaded_image2',
              soldOutId 	= '$soldOutId',
              WHERE productId = '$id' ";
          
              $updated_row = $this->db->update($query);
              if ($updated_row) {
                    $msg = "<span class='success'>Product Updated Successfully.</span> ";
                    return $msg;
                }else {
                    $msg = "<span class='error'>Product Not Updated .</span> ";
                    return $msg;
                } 
         }
     
          } else{
               $query = "UPDATE tbl_product
              SET 
              productName 	= '$productName',
              sizeId 		= '$sizeId',
              colorId 		= '$colorId',
              productPrice 	= '$productPrice'
              soldOutId 	= '$soldOutId',
              WHERE productId = '$id' ";
     
              $updated_row = $this->db->update($query);
              if ($updated_row) {
                    $msg = "<span class='success'>Product Updated Successfully.</span> ";
                    return $msg; // return This Message 
                }else {
                    $msg = "<span class='error'>Product Not Updated .</span> ";
                    return $msg; // return This Message 
                } 
     
                 }
            }
     
         }

         public function delProById($id){
            $query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
            $getData = $this->db->select($query);
                if ($getData) {
                    while ($delImg = $getData->fetch_assoc()) {
                    $dellink = $delImg['productImg1'];
                         unlink($dellink);
                         $dellink = $delImg['productImg2'];
                            unlink($dellink);
                       }
                       
                   }
            
                    $delquery = "DELETE FROM tbl_product WHERE productId = '$id' ";
                       $deldata = $this->db->delete($delquery);
                     if ($deldata) {
                         $msg = "<span class='success'>Product Deleted Successfully.</span> ";
                     return $msg;
                     }else {
                         $msg = "<span class='error'>Product Not Deleted .</span> ";
                            return $msg;
                         } 
           }

           public function getAllSoldOut(){ 
            $query = "SELECT * FROM tbl_soldOut";
          $result = $this->db->select($query);
          return $result; 
        }


        public function soldOut($soldOut, $id){
 
            $soldOut = $this->fm->validation($soldOut);
            $soldOut =  mysqli_real_escape_string($this->db->link, $soldOut );
            $id =  mysqli_real_escape_string($this->db->link, $id );
        
            if (empty($soldOut)) {  // Check empty filed 
                $msg = "<span class='error'> Field Must Not be empty.</span> ";
                return $msg;
        
            }else {
            $query = "UPDATE tbl_soldOut
                   SET
                   soldOut = '$soldOut'
                   WHERE soldOutId = '$soldOutId' ";
                   $update_row  = $this->db->update($query);
                   if ($update_row) {
                       $msg = "<span class='success'>Color Updated Successfully.</span> ";
                       return $msg; // return message 
                   }else {
                       $msg = "<span class='error'>Color Not Updated .</span> ";
                       return $msg; // return message 
                   }
        
            }
        
        }
}