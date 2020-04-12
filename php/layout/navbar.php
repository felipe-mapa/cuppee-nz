<?php
include 'lib/Session.php';   // include Session file
Session::init();   // Start our session with init method
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../../lib/Database.php');
include_once ($filepath.'/../../helpers/Format.php');

spl_autoload_register(function($class){
	include_once "classes/".$class.".php";
});

$db = new Database();   // Create Database Class Object 
$fm = new Format();  // Create Format Class Object 
$pd = new Product(); // Create Product Class Object 
$ct = new Cart(); // Create Cart Class Object 
$cmr = new Shipping(); // Create Shipping Class Object 
$ord = new Order(); // Create Order Class Object 

?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link href="https://fonts.googleapis.com/css?family=Griffy&amp;subset=latin-ext" rel="stylesheet">
        <meta name="google-site-verification" content="m8RHfPE9me2Pr8IPeXlen4pHLb-YR_tAd_1RLeErpUs" />
        
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" type="image/png" href="./img/transparent-background/cuppee-blue-compressed-transparent.png">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/south-street/theme.min.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="js/autocomplete.js"></script>
        <script src="js/main.js"></script>    

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136798657-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-136798657-1');
        gtag('config', 'AW-713075571');
        </script>

    </head>
    <body>
        <?php $quantityInCart = $ct->countQuantity();
        $getData = $ct->checkCartTable();
        ?>
        <nav class="navigation navigation__solid-color">
            <div class="navigation__container">
                <a class="navigation__logo" href="http://www.cuppee-nz.com/"><img src="img/cuppee-logo.png" alt="Cuppee logo" class="navigation__logo"></a>
                <ul class="navigation__menu">
                    <li class="navigation__list"><a class="navigation__item" href="http://www.cuppee-nz.com/">Home</a></li>
                    <li class="navigation__list"><a class="navigation__item" href="products">Products</a></li>
                    <li class="navigation__list"><a class="navigation__item" href="about">About Us</a></li> 
                    <li class="navigation__list"><a class="navigation__item" href="contact-form">Contact Us</a></li> 
                    <li class="navigation__list"><a class="navigation__item" href="cart">Cart <?php if ($getData) { ?>(<?php echo $quantityInCart ?>) <?php } ?></a></li> 
                </ul>
            </div>
        </nav>