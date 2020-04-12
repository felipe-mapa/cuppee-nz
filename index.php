<?php
include 'lib/Session.php';   // include Session file
Session::init();   // Start our session with init method
include_once "classes/Cart.php";
$ct = new Cart(); // Create Cart Class Object 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta property="image" content="img/mixed/all-cups.JPG">
        <link href="https://fonts.googleapis.com/css?family=Griffy&amp;subset=latin-ext" rel="stylesheet">
        <meta name="google-site-verification" content="m8RHfPE9me2Pr8IPeXlen4pHLb-YR_tAd_1RLeErpUs" />
        
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" type="image/png" href="./img/transparent-background/cuppee-blue-compressed-transparent.png">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script type="text/javascript" src="js/main.js"></script>     
        <script type="text/javascript" src="js/aos-animation.js"></script>     
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129271937-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-129271937-1');
        </script>
        
        <title>Cuppee | Reusable Cup</title>
    </head>
    <body>
        <?php $quantityInCart = $ct->countQuantity();
            $getData = $ct->checkCartTable();
        ?>
        <nav class="navigation navigation-transparent">
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
        <main>
            <div class="fixed-img first__img"></div>
            <section class="section-description" id="section-description">
                <h1 class="primary-header section-description__header">Be Smart. Compact. Ecological.</h1>
                <div class="section-description__container">
                    <div class="section-description-pic">
                        <div class="section-description-pic__img"><img src="img/transparent-background/cuppee-purple-transparent.png" alt="Cuppee img" class="section-description-pic__img section-description-pic__img--3"></div> <!--data-aos="fade-right" data-aos-once="true" data-aos-delay="1000"-->
                        <div class="section-description-pic__img"><img src="img/transparent-background/cuppee-grey-transparent.png" alt="Cuppee img" class="section-description-pic__img section-description-pic__img--2"></div> <!--data-aos="fade-right" data-aos-once="true" data-aos-delay="500"-->
                        <div class="section-description-pic__img"><img src="img/transparent-background/cuppee-blue-transparent.png" alt="Cuppee img" class="section-description-pic__img section-description-pic__img--1"></div> <!--data-aos="fade-right" data-aos-once="true"-->
                   </div>
                    <ul class="section-description__list"> <!-- data-aos="zoom-in-left" data-aos-once="true" data-aos-delay="1500"-->
                        <li class="section-description__item section-description__item--1 fab fa-envira"><span class="section-description__item"> Protect the environment</span></li>
                        <li class="section-description__item section-description__item--2 fas fa-thermometer-three-quarters"><span class="section-description__item"> Heat resistant</span></li>
                        <li class="section-description__item section-description__item--3 fas fa-tint"><span class="section-description__item"> Leak proof</span></li>
                        <li class="section-description__item section-description__item--4 fas fa-suitcase"><span class="section-description__item"> Take it anywhere</span></li>
                        <li class="section-description__item section-description__item--5 fas fa-dollar-sign"><span class="section-description__item"> Get discounts on coffee</span></li>
                    </ul>
                </div>
            </section>    


            <div class="fixed-img second__img"></div>

            <section class="section-ultilities">
                    <h1 class="primary-header">Take it everywhere, at anytime.</h1>
                    <div class="section-ultilities__gallery" id="gallery">
                        <a class="btn" id="btn-left"><i class="fa fa-chevron-left"></i></a>
                        <div class="section-ultilities__slides" id="slides">
                            <div class="slide section-ultilities__slides--1">
                                <img src="./img/main-page/cuppee-on-pocket.JPG" alt=""/>
                                <div class="section-ultilities__slides--bg"></div>
                                <div class="section-ultilities__slides--text">
                                    <h2 class="section-ultilities__header">Compact</h2>
                                    <p class="section-ultilities__paragraph">Cuppee is collapsible, so you can fold it up and put it in your pocket – it can go with you anywhere you want!</p>                            
                                </div>
                            </div>
                            <div class="slide section-ultilities__slides--2">
                                <img src="./img/main-page/barista-with-cuppee.jpg" alt=""/>
                                <div class="section-ultilities__slides--bg"></div>
                                <div class="section-ultilities__slides--text">
                                    <h2 class="section-ultilities__header">Get discount using Cuppee</h2>
                                    <p class="section-ultilities__paragraph">Most of the cafes in New Zealand give discount to people using reusable cups</p>                            
                                </div>
                            </div>
                            <div class="slide section-ultilities__slides--3">
                                <img src="./img/mixed/all-cups.JPG" alt=""/>
                                <div class="section-ultilities__slides--bg"></div>
                                <div class="section-ultilities__slides--text">
                                    <h2 class="section-ultilities__header">Help the World we live.</h2>
                                    <p class="section-ultilities__paragraph">By using Cuppee, you can stop contributing to the millions of disposable coffee cups that go to landfill each year.</p>                            
                                </div>
                            </div>
                        </div>
                        <a class="btn" id="btn-right"><i class="fa fa-chevron-right"></i></a>
                    </div>
                    <script src="js/change-picture.js"></script> 
            </section>

            <div class="fixed-img third__img"></div>

            <section class="section-testimonial">
                    <h1 class="primary-header primary-header--green">Testimonial</h1>
                <div class="section-testimonial__container">
                    <div class="section-testimonial__testimonial">
                        <figure class="section-testimonial__quote">
                            <blockquote class="section-testimonial__paragraph">It's like the optimus prime of coffee cups.</blockquote>
                        </figure>
                        <h3 class="section-testimonial__author">- Guy in cafe</h3>
                    </div>
                    <div class="section-testimonial__testimonial">
                        <figure class="section-testimonial__quote">
                            <blockquote class="section-testimonial__paragraph">I feel so much better now that I can have my daily coffee without polluting the environment!</blockquote>
                        </figure>
                        <h3 class="section-testimonial__author">- Thomas</h3>
                    </div>
                    <div class="section-testimonial__testimonial">
                        <figure class="section-testimonial__quote">
                            <blockquote class="section-testimonial__paragraph">Very well packaged and fast delivery. Many thanks.</blockquote>
                        </figure>
                        <h3 class="section-testimonial__author">- Janet</h3>
                    </div>
                </div>
            </section>

            <section class="section-how_to_use">
                    <h1 class="primary-header">How to use:</h1>
                <iframe class="section-how_to_use__video" src="https://www.youtube.com/embed/SWO0Ii2mE6k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </section>
<?php include 'php/layout/footer.php';?>