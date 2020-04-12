<?php 
 $filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 ?>

<?php
class Session{
    public static function init(){
        session_start();
    }

    public static function set($key, $val){
        $_SESSION[$key] = $val;
    }

    public static function get($key){
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }   
        else {
            return false;
        }
    }
    
    public static function checkLogin(){
        self::init(); // Here i stat this session with init method
        if (self::get("adminlogin") == true) {
            header("Location:dashboard.php"); // I just put the transfer location as dashboard.php page
            }
    }

    public static function checkSession(){
        self::init();
        if (self::get("adminlogin") == false) {
            self::destroy(); // I added this when is will false then its will be apply selt::destroy method
            header("Location:login.php"); // Here is define its will be transfer to admin login.php page
           }
    }

    public static function destroy() {
        //session_destroy();
        header("Location:login.php");
    }

}

?>