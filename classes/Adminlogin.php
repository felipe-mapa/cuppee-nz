<?php 
 $filepath = realpath(dirname(__FILE__));
 include_once ($filepath.'/../lib/Session.php');
 Session::checkLogin();
 
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
  
?>

<?php
class Adminlogin{
    private $db;  // Database class property 
    private $fm;  // Format class property 

    public function __construct(){
        $this->db   = new Database(); // Object for Database Class
        $this->fm   = new Format();   // Object for Format Class
    }

    public function adminLogin($adminUser, $adminPass) {
        $adminUser = $this->fm->validation($adminUser);     //here i with this format class object i access the method
        $adminPass = $this->fm->validation($adminPass);     //here i with this format class object i access the method

        $adminUser =  mysqli_real_escape_string($this->db->link, $adminUser ); // our login filed adminUser 
        $adminPass =  mysqli_real_escape_string($this->db->link, $adminPass ); // our login filed adminPass 

        if (empty($adminUser) || empty($adminPass)) {
            $loginmsg = "User name or Password must not be empty"; // I take one variable as $loginmsg 
            return $loginmsg;
        }else {
            $query = "SELECT * FROM tbl_admin WHERE adminUser='$adminUser' AND adminPass='$adminPass' ";
    		$result = $this->db->select($query);
    		if ($result != false) {
    			$value = $result->fetch_assoc();
    			Session::set("adminlogin", true);
    			Session::set("adminId", $value['adminId']);
    			Session::set("adminUser", $value['adminUser']);
    			Session::set("adminName", $value['adminName']);
    			header("Location:dashboard.php");
    		}else {
    			$loginmsg = "username or password not match ";
    			return $loginmsg; // here we return this message we have to get this msg letter for display this text.
    		}
        }
    }
}