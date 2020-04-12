<?php include 'php/layout/navbar.php';?>

<?php 
    $result = $pd->getAllProduct()->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $quantity = $_POST['quantity'];
        $productId = $_POST['submit'];
        $addCart = $ct->addToCart($quantity, $productId);
    }   
?>

<head><title>Cuppee | Products</title></head>

        <div class="products">
            <h1 class="primary-header products__header">Products</h1>
            <div class="products__container">
            <?php 
                $getProduct = $pd->getAllProduct(); // With Product class object i create on method 
                if ($getProduct) {
                    while ($result = $getProduct->fetch_assoc()) {
            ?> 

                <?php
                        $soldOut = new Product();
                        $getSoldOut =  $soldOut->getAllSoldOut();
    
                        if ($result['soldOutId'] == "1") { ?>
                            <div style="
                            background-color: #ffffff;
                            opacity: 0.6;
                            filter: alpha(opacity=60);">
                <?php }    ?>
            <div class="products__box">
                <h2 class="products__color products__color--<?php echo $result['colorName']; ?>"><?php echo $result['colorName']; ?></h2>
                <div class="products__images">
                    <img class="products__img" src="admin/<?php echo $result['productImg1']; ?>" alt="">
                    
                    <?php if($result['productImg2'] != " "){ ?>
                        <img class="products__img" src="admin/<?php echo $result['productImg2']; ?>" alt="">
                    <?php } ?>  
                    
                    <!-- Second picture
                    <?php if($file_ext1 != NULL){ ?>
                        <a class="products__arrow products__arrow--left" onclick="plusDivs(this,-1)">&#10094;</a>
                        <a class="products__arrow products__arrow--right" onclick="plusDivs(this,1)">&#10095;</a>
                        <?php } ?>  
                    -->
                    <div class="products__cart">
                        <!-- Price -->
                        <?php
                        $soldOut = new Product();
                        $getSoldOut =  $soldOut->getAllSoldOut();
    
                        if ($result['soldOutId'] == "1") { ?>
                        <p style="font-weight: bold; font-size: 30px; color: #000000; margin: 0;">SOLD OUT</p>
                <?php }  else {  ?>
                        <h2 style="margin:auto 0;"><span class="products__price">$<?php echo $result['productPrice']/100; ?></span></h2>
                        <form class="products__form" action=" " method="post">
                            <input class="products__quantity" type="number" name="quantity"  id="select" min="1" value="1"/>
                            <button class="products__add" type="submit" class="buysubmit" name="submit" value="<?php echo $result['productId']; ?>" id="<?php echo $result['productId']; ?>">Add to cart</button>
                        </form>	
                        <?php  }   ?>		
			        </div>
                </div>
                <?php
    
                        if ($result['soldOutId'] == "1") { ?>
                            </div>
                <?php  }   ?>
            </div>
            
            <?php  }  }  ?>	


            </div>
        </div>

        <script src="js/slideshow-products.js"></script>

<?php include 'php/layout/footer.php';?>