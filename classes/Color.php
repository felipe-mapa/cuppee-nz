<?php 
 $filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 ?>
 
<?php
    class Color{
        private $db;  // I crate Property for Database Class
        private $fm; // I crate Property for Format Class  
    
        public function __construct(){
        $this->db   = new Database(); // I crate Object for Database Class
        $this->fm   = new Format(); // I crate Object for Format Class  
        }
        
        public function colorInsert($colorName){  // Our method with id 
            $colorName = $this->fm->validation($colorName);
            $colorName =  mysqli_real_escape_string($this->db->link, $colorName );
    
            if (empty($colorName)) { // validation for empty check 
                $msg = "Color Field must not be empty";
                return $msg;
                }else {
                    $query = "INSERT INTO tbl_color(colorName) VALUES ('$colorName')"; // Insert Query 
                    $colorInsert = $this->db->insert($query);
                if ($colorInsert) {
                    $msg = "<span class='success'>Color Inserted Successfully.</span> ";
                    return $msg; // return Message 
                }else {
                    $msg = "<span class='error'>Color Not Inserted .</span> ";
                    return $msg; // return Message 
                }
            }
        }

        public function getAllColor(){ 
            $query = "SELECT * FROM tbl_color ORDER BY colorId DESC";
          $result = $this->db->select($query);
          return $result; 
        }

        public function getUpdatetById($id){
            $query = "SELECT * FROM tbl_color WHERE colorId ='$id' ";
            $result = $this->db->select($query);
            return $result;
        }

        public function colorUpdate($colorName, $id){
 
            $colorName = $this->fm->validation($colorName);
            $colorName =  mysqli_real_escape_string($this->db->link, $colorName );
            $id =  mysqli_real_escape_string($this->db->link, $id );
        
            if (empty($colorName)) {  // Check empty filed 
                $msg = "<span class='error'>Color Field Must Not be empty.</span> ";
                return $msg;
        
            }else {
            $query = "UPDATE tbl_color
                   SET
                   colorName = '$colorName'
                   WHERE colorId = '$id' ";
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

        public function delColorById($id){
            $query = "DELETE FROM tbl_color WHERE colorId ='$id' ";
            $colordeldata = $this->db->delete($query);
            if ($colordeldata) {
                $msg = "<span class='success'>color Deleted Successfully.</span> ";
            return $msg; // return this message 
            }else {
                $msg = "<span class='error'>color Not Deleted .</span> ";
                   return $msg; // return this message 
                }
        }
    }
?>
