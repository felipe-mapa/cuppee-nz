<?php include 'php/layout/navbar.php';?>

<?php 
	$getAddress = $cmr->getAddress();
	$a = $getAddress->fetch_assoc();
?>
<title>Cuppee | Payment</title>
<div class="payment">
	<div class="payment__container">
		<div class="payment__box">
			<h1 class="payment__header">Cart review</h1>
			<table class="payment__table">
				<tr class="payment__table--row">
					<th class="payment__table--header"></th>
					<th class="payment__table--header">Product</th>
					<th class="payment__table--header">Qty</th>
					<th class="payment__table--header">Price</th>
				</tr>

				<?php
					$getProduct = $ct->getCartProduct();
					$totalPrice = $ct->totalPrice();
					//display products
						$i = 0;
						while ($result = $getProduct->fetch_assoc()) {
							$i++;
				?>
				<tr class="payment__table--row">
					<td class="payment__table--data"><?php echo $i;  ?></td>
					<td class="payment__table--data"><?php echo $result['productName'];  ?></td>
					<td class="payment__table--data"><?php echo $result['quantity'];  ?></td>
					<td class="payment__table--data">$
						<?php 
							$total = $result['productPrice'] * $result['quantity'];
							echo number_format($total/100, 2); 
						?>			
					</td>
				</tr>
				<?php }   ?> 
								
			</table>

			<table class="payment__table payment__table--total">
				<tr class="payment__table--row">
					<th class="payment__table--total-h">Shipping: </th>
					<td class="payment__table--total-h"> FREE</td>
				</tr>
				<tr class="payment__table--row">
					<th class="payment__table--total-h">Grand Total:</th>
					<td class="payment__table--total-h">
						<?php echo"$".number_format($totalPrice/100, 2); ?>
					</td>
				</tr>
			</table>
		</div>
		<script type="text/javascript">
    // Address lookup instance
    var addyComplete = new AddyComplete(document.getElementById("address1"));
    
    // Register a function to receive the selected address object
    addyComplete.addressSelected = function(address) {
        console.log("Selected address object: ", address);
    }
</script>

		<div class="payment__box">
			<h1 class="payment__header">Shipping detail</h1>
			<table class="payment__table payment__table--shipping">
				<tr class="payment__table--row">
					<th class="payment__table--total-h">Customer: </th>
					<td class="payment__table--total-h"><?php echo $a['customerName']; ?></td>
				</tr>
				<tr class="payment__table--row">
					<th class="payment__table--total-h">Address:</th>
					<td class="payment__table--total-h"><?php echo $a['shippingAddress1'].$a['shippingAddress2']; ?></td>
				</tr>
				<tr class="payment__table--row">
					<th class="payment__table--total-h">Suburb: </th>
					<td class="payment__table--total-h"><?php echo $a['shippingSuburb']; ?></td>
				</tr>
				<tr class="payment__table--row">
					<th class="payment__table--total-h">City: </th>
					<td class="payment__table--total-h"><?php echo $a['shippingCity']; ?></td>
				</tr>
				<tr class="payment__table--row">
					<th class="payment__table--total-h">Postcode: </th>
					<td class="payment__table--total-h"><?php echo $a['shippingPostcode']; ?></td>
				</tr>
				<tr class="payment__table--row">
					<th class="payment__table--total-h">Country: </th>
					<td class="payment__table--total-h"><?php echo $a['shippingCountry']; ?></td>
				</tr>
				<?php if($a['shippingMessage'] != ''){ ?>
				<tr class="payment__table--row">
					<th class="payment__table--total-h">Delivery note: </th>
					<td class="payment__table--total-h"><?php echo $a['shippingMessage']; ?></td>
				</tr>
				<?php } ?>
			</table>
			<div class="cart__buttons--box">
				<a id="form__submission" style="margin: 0 auto;" class="btn-contact cart__buttons--button" name="submit" type="submit" href="shipping">&#8592; Update shipping</a>
			</div>
		</div>
	</div>

	<div class="payment__method">
		<h1 class="payment__header">Payment method</h1>
		<?php $sId = $a['sId'] ?>
		<div class="payment__method--card">
			<form action="stripeIPN" method="POST" name="createOrder">
				<script
					src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					data-key="pk_live_uTX16Ulj2PslITlAkxh4YLNx"
					data-amount= "<?php echo $totalPrice ?>"
					data-name="Cuppee-NZ"
					data-email="<?php echo $a['customerEmail']; ?>"
					data-description="Reusable coffee cup"
					data-image="./img/transparent-background/cuppee-blue-compressed-transparent.png"
					data-locale="auto"
					data-currency="nzd">
				</script>
			</form>
		</div>
	</div>
</div>
			
<?php include 'php/layout/footer.php';?>