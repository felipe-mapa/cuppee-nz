<?php include 'php/layout/navbar.php';

	//DELETE PRODUCT
  	if (isset($_GET['delpro'])) {
		$delId = $_GET['delpro'];
		$delProduct = $ct->delProductByCart($delId);
	}
	
	//UPDATE QUANTITY
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$cartId = $_POST['cartId'];
		$quantity = $_POST['quantity'];
		$updateCart = $ct->updateCartQuantity($cartId, $quantity);
	}
?>
<title>Cuppee | Cart <?php if ($getData) { ?>(<?php echo $quantityInCart ?>) <?php } ?></title>
<div class="cart__main">
	<div class="cart" id="cart">
		<h1 class="primary-header form__header">Cart</h1>
		<?php
		//update
		if (isset($updateCart)) {
			echo $updateCart;
		} 
		//delete
		if (isset($delProduct)) {
			echo $delProduct;
		}
		?>
		<?php 
			$getData = $ct->checkCartTable();
			if ($getData) {
		?>
		<div class="cart__tables">
			<div class="overflow" id="overflow">
			<table class="cart__table cart__table--big">
				<thead>
					<tr class="cart__table--row">
						<th class="cart__table--header" width="2px"></th>
						<th class="cart__table--header">Image</th>
						<th class="cart__table--header">Product Name</th>
						<th class="cart__table--header">Price</th>
						<th class="cart__table--header">Quantity</th>
						<th class="cart__table--header">Total Price</th>
						<th class="cart__table--header">Delete</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$getProduct = $ct->getCartProduct();
					$totalPrice = $ct->totalPrice();
					//display products
					if ($getProduct) {
						$i = 0;
						while ($result = $getProduct->fetch_assoc()) {
							$i++;
				?>
				<tr class="cart__table--row">
					<td class="cart__table--data" width="2px"><?php echo $i;  ?></td>
					<td class="cart__table--data"><img src="admin/<?php echo $result['productImg1']; ?>" alt=""/></td>
					<td class="cart__table--data"><?php echo $result['productName'];  ?></td>
					<td class="cart__table--data">$<?php echo $result['productPrice']/100;  ?></td>
					<td class="cart__table--data">
						<form class="cart__table--form" action="" method="post">
							<input type="hidden" name="cartId" value="<?php echo $result['cartId'];  ?>"/>
							<input type="number" min="1" name="quantity" value="<?php echo $result['quantity'];  ?>"/>
							<input type="submit" name="submit" value="Update"/>
						</form>
					</td>
					<td class="cart__table--data">
						<?php 
							$total = $result['productPrice'] * $result['quantity'];
							echo "$".number_format($total/100, 2); 
						?>			
					</td>
					
					<td class="cart__table--data"><a onclick="return confirm('Are you sure to Delete');" href="?delpro=<?php echo $result['cartId']; ?>">X</a></td>
				</tr>
				<?php } }   ?> 
				</tbody>			
			</table>
			</div>
			<?php 
				if ($getData) {
			?>

			<table class="cart__table cart__table--total">
				<tr class="cart__table--row">
					<th class="cart__table--total-h">Shipping: </th>
					<td class="cart__table--total-h"> FREE</td>
				</tr>
				<tr class="cart__table--row">
					<th class="cart__table--total-h">Grand Total:</th>
					<td class="cart__table--total-h">
						<?php echo"$".number_format($totalPrice/100, 2); ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php } ?>

	<?php } else { ?>
		<h1 class="cart__empty">Your cart is empty :(</h1>
		<h1 class="cart__empty">Start shopping now</h1>
	<?php } ?>
	<div class="cart__buttons">
		<?php if ($getData) { ?>
			<div class="cart__buttons--box cart__buttons--hide">
				<a id="form__submission" class="cart__buttons--hide btn-contact cart__buttons--button" name="submit" type="submit" href="products">&#8592; Continue shopping</a>
			</div>
			<div class="cart__buttons--box">
				<a id="form__submission" class="btn-contact cart__buttons--button" name="submit" type="submit" href="shipping">Go to shipping &rarr;</a>
			</div>
		<?php } else {?>
			<div class="cart__buttons--box">
				<a id="form__submission" class="btn-contact cart__buttons--button" name="submit" type="submit" href="products">&#8592; See product range</a>
			</div>
		<?php } 
	?>
    </div>
</div>

<?php include 'php/layout/footer.php';?>