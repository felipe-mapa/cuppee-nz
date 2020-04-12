<head><link rel="stylesheet" href="style.css"></head>
<?php include 'php/layout/navbar.php';?>
<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) ) {
		$cartId = $_POST['cartId'];
		$quantity = $_POST['quantity'];
		$updateCart = $ct->updateCartQuantity($cartId, $quantity);
		if ($quantity <= 0) {
			$delProduct = $ct->delProductByCart($cartId);
		} 
	}else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saveShipping']) ) {
        $customerReg = $cmr->customerRegistration($_POST);
	}
?>
<?php
	$getAddress = $cmr->getAddress();
	if (!empty($getAddress)){
		$a = $getAddress->fetch_assoc();
	}
?>	
<title>Cuppee | Shipping</title>
<div class="shipping">
    <form class="shipping__form" method="post" action="">
        <div class="shipping__block--1">
            <h1 class="shipping__paragraph">Contact details</h1>
            <div class="shipping__group">
                <label for="name" class="shipping__label">Full name*</label>
                <input type="text" class="shipping__input" name="customerName" <?php if (!empty($getAddress)){?> value="<?php echo $a['customerName']; }?>" required>
            </div>

            <div class="shipping__group">
                <label for="email" class="shipping__label">Email address*</label>
                <input type="email" class="shipping__input" name="customerEmail"  <?php if (!empty($getAddress)){?> value="<?php echo $a['customerEmail']; }?>"required>
            </div>

            <div class="shipping__group">
                <label for="mobile" class="shipping__label">Mobile</label>
                <input type="mobile" class="shipping__input" name="customerMobile" <?php if (!empty($getAddress) && $a['customerMobile'] != 0){?> value="<?php echo $a['customerMobile']; }?>">
			</div>
        </div>

        <div class="shipping__block--2">
            <h1 class="shipping__paragraph">Shipping details</h1>
            <div class="shipping__group">
                <label for="address1" class="shipping__label">Address 1*</label>
                <input type="search" id="address1" class="shipping__input" name="shippingAddress1" <?php if (!empty($getAddress)){?> value="<?php echo $a['shippingAddress1']; }?>"required/>
            </div>

            <div class="shipping__group">
                <label for="address2" class="shipping__label">Address 2</label>
                <input type="text" id="address2" class="shipping__input" name="shippingAddress2" <?php if (!empty($getAddress)){?> value="<?php echo $a['shippingAddress2']; }?>"/>
            </div>

            <div class="shipping__group">
                <label for="suburb" class="shipping__label">Suburb*</label>
                <input type="text" id="suburb" class="shipping__input" name="shippingSuburb" <?php if (!empty($getAddress)){?> value="<?php echo $a['shippingSuburb']; }?>" required/>
            </div>

            <div class="shipping__compress">
                <div class="shipping__group">
                <label for="city" class="shipping__label">City*</label>
                <input type="text" id="city" class="shipping__input" name="shippingCity" <?php if (!empty($getAddress)){?> value="<?php echo $a['shippingCity']; }?>" required/>
                </div>
                <div class="shipping__group shipping__group--post">
                <label for="postcode" class="shipping__label">Postcode*</label>
                <input type="text" id="postcode" class="shipping__input" name="shippingPostcode" <?php if (!empty($getAddress)){?> value="<?php echo $a['shippingPostcode']; }?>" required/>
                </div>
			</div>
			
			<div class="shipping__group">
                <label for="country" class="shipping__label">Country*</label>
                <input type="text" id="country" class="shipping__input" name="shippingCountry" value="New Zealand" <?php if (!empty($getAddress)){?> value="<?php echo $a['shippingCountry']; }?>" disabled/>
            </div>
            <!-- <div class="shipping__group">
                <label for="type" class="shipping__label">Type</label>
                <input type="text" id="type" class="shipping__input" name="shippingType" <?php if (!empty($getAddress)){?> value="<?php echo $a['shippingType']; }?>" disabled/>
            </div> -->

            <div class="shipping__group">
                <label for="message" class="shipping__label">Delivery note</label>
                <textarea rows="1" class="shipping__input" name="shippingMessage" type="text"><?php if (!empty($getAddress)){ echo $a['shippingMessage']; }?></textarea>
			</div> 

			<div class="shopright">
				<div class="form__group">
					<button type="submit" class="btn-contact shipping__button" name="saveShipping">Checkout &rarr;</button>
				</div>
			</div>
        </div>
    </form>
</div>
    
<?php include 'php/layout/footer.php';?>