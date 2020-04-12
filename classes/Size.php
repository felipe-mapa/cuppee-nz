<?php 
 $filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 ?>

<?php
    class Size {
        private $db;  // Database class property 
        private $fm;  // Format class property 
    
        public function __construct(){
            $this->db   = new Database(); // Object for Database Class
            $this->fm   = new Format();   // Object for Format Class
        }

        public function sizeInsert($sizeName){                
            $sizeName = $this->fm->validation($sizeName); // Validation for special Characters             
            $sizeName =  mysqli_real_escape_string($this->db->link, $sizeName ); // Validation for mysqli   
            if (empty($sizeName)) {
                 $msg = "Size Field must not be empty"; // validation for empty 
                 return $msg;
                }else {
                    $query = "INSERT INTO tbl_size(sizeName) VALUES ('$sizeName')";  
                    $sizeinsert = $this->db->insert($query);
                    if ($sizeinsert) {
             $msg = "<span class='success'>Size Inserted Successfully.</span> "; // I create one span class
                 return $msg; // Here i return this Message 
                    }else {
             $msg = "<span class='error'>Size Not Inserted .</span> "; // I create one span class as error
                 return $msg; // Here i return this Message 
                    }
             }
        }

        public function getAllSize(){
            $query = "SELECT * FROM tbl_size ORDER BY sizeId DESC";
            $result = $this->db->select($query);
            return $result;
        }

        public function getSizeById($id){
            $query = "SELECT * FROM tbl_size WHERE sizeId ='$id' ";
            $result = $this->db->select($query);
            return $result;
        }

        public function sizeUpdate($sizeName, $id){
            $sizeName = $this->fm->validation($sizeName);
            $sizeName =  mysqli_real_escape_string($this->db->link, $sizeName );
            $id =  mysqli_real_escape_string($this->db->link, $id );
            if (empty($sizeName)) {
                $msg = "<span class='error'>Size Field Must Not be empty.</span> ";
                return $msg;
            }else {
                   $query = "UPDATE tbl_size
                   SET
                   sizeName = '$sizeName'
                   WHERE sizeId = '$id' ";
                   $update_row  = $this->db->update($query);
                   if ($update_row) {
                       $msg = "<span class='success'>Size Updated Successfully.</span> ";
                       return $msg; //Return the Message 
                   }else {
                       $msg = "<span class='error'>Size Not Updated .</span> ";
                       return $msg; // Return the Message 
                   }
            }
        
        }

        public function delsizeById($id){
            $query = "DELETE FROM tbl_size WHERE sizeId ='$id' ";
            $deldata = $this->db->delete($query);
            if ($deldata) {
                $msg = "<span class='success'>Size Deleted Successfully.</span> ";
            return $msg; // return this Message 
            }else {
                $msg = "<span class='error'>Size Not Deleted .</span> ";
                   return $msg; // return this Message 
                }
        }
    }
    

?>