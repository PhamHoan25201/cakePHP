<?php

echo $this->element('NormalUsers/header');
?>
<div class="row" style="margin-left: 5px">
	<?= $this->Flash->render() ?>
</div>
<div class="product-big-title-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="product-bit-title text-center">
					<?php if (isset($dataUser)) { ?>
						<h2>Xác Nhận Đơn Hàng</h2>
					<?php } else { ?>
						<h2>Thông Tin Khách Hàng</h2>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="single-product-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="product-content-right">
					<div class="woocommerce">
						<?php if (isset($dataUser)) { ?>
							<form enctype="multipart/form-data" action="/addOrders" class="checkout" method="post" name="checkout">
								<div id="customer_details" class="col2-set">
									<div class="col-3">
										<h3 id="order_review_heading">Thông Tin Khách hàng</h3>
										<table class="shop_table">
											<?php foreach ($dataUser as $User) { ?>
												<tbody>
													<tr class="cart_item">
														<th class="product-name">
															Họ Và Tên
														</th>
														<td class="product-total">
															<span class="amount"><?= h($User['username']) ?></span>
														</td>
													</tr>

													<tr class="cart_item">
														<th class="product-name">
															Số Điện Thoại
														</th>
														<td class="product-total">
															<span class="amount"><?= h($User['phonenumber']) ?> </span>
														</td>
													</tr>

													<tr class="cart_item">
														<th class="product-name">
															Địa chỉ Email
														</th>
														<td class="product-total">
															<span class="amount"><?= h($User['email']) ?> </span>
														</td>
													</tr>

													<tr class="cart_item">
														<th class="product-name">
															Địa chỉ
														</th>
														<td class="product-total">
															<span class="amount"><?= h($User['address']) ?></span>
														</td>
													</tr>
												</tbody>
											<?php } ?>
										</table>
									</div>
									<div class="col-3">
										<h3 id="order_review_heading"> Thông Tin Đơn Hàng</h3>
										<div id="order_review" style="position: relative;">
											<table class="shop_table">
												<thead>
													<tr>
														<th class="product-name">Sản phẩm</th>
														<th class="product-total">Tổng</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($dataProds['cart'] as  $product) { ?>
														<tr class="cart_item">
															<td class="product-name">
																<?= $product['name'] ?> <strong class="product-quantity">× <?= $product['quantity'] ?></strong> </td>
															<td class="product-total">
																<span class="amount"><?= '$' . number_format($product['totalAmount']) ?></span>
															</td>
														</tr>
													<?php } ?>
												</tbody>
												<tfoot>
													<tr class="shipping">
														<th>Point Đơn hàng </th>
														<td>
															<?= number_format($dataProds['totalAllPoint']) . ' point' ?>
														</td>
													</tr>
													<tr class="shipping">
														<th>Point Hiện có</th>
														<td>
															<?= number_format($dataUser[0]['point_user']) . ' point' ?>
														</td>
													</tr>
													<tr class="shipping">
														<th>Point Sau khi mua</th>
														<td>
															<?= number_format($dataProds['totalAllPoint'] + $dataUser[0]['point_user']) . ' point' ?>
														</td>
													</tr>
													<tr class="order-total">
														<th>Tổng Đơn Hàng</th>
														<td><strong><span class="amount"><?= '$' . number_format($dataProds['totalAllAmount']) ?></span></strong> </td>
													</tr>
												</tfoot>
											</table>
											<div class="col-3">
												<div id="order_review" style="position: relative; display: inline-block;">
													<div id="payment">
														<div class="form-row place-order">
															<a href="/carts">
																<input type="button" data-value="Place order" value="Back" id="place_order" name="woocommerce_checkout_place_order" class="button alt button_back">
															</a>
														</div>
														<div class="clear"></div>
													</div>
												</div>
												<div id="order_review" style="position: relative; float: right;">
													<div id="payment">
														<div class="form-row place-order">
															<input type="submit" data-value="Place order" value="Xác nhận" id="place_order" name="woocommerce_checkout_place_order" class="button alt">
														</div>
														<div class="clear"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
					</div>
					</form>
				<?php } else { ?>
					<form enctype="multipart/form-data" action="/addUser" class="checkout" method="post" name="checkout">
						<div id="customer_details" class="col2-set">
							<div class="col-3">
								<div class="woocommerce-billing-fields">
									<h3>Thông tin khách hàng</h3>
									<p id="billing_first_name_field" class="form-row form-row-first validate-required">
										<label class="" for="billing_first_name">Họ và tên <abbr title="required" class="required">*</abbr>
										</label>
										<input <?php if (isset($_SESSION['error']['username'])) { ?> style="border-color: red; color: red;" <?php } ?> type="text" value=" <?php if (isset($_SESSION['cartData']['infoUser']['username'])) {
																																												echo h($_SESSION['cartData']['infoUser']['username']);
																																											} ?>" placeholder="" id="billing_first_name" name="username" class="input-text ">
										<?php if (isset($_SESSION['error']['username'])) { ?>
											<i style="color: red;">
												<?= implode($_SESSION['error']['username']) ?>
											</i>
										<?php } ?>
									</p>
									<div class="clear"></div>
									<p id="billing_address_1_field" class="form-row form-row-wide address-field validate-required">
										<label class="" for="billing_address_1">Địa chỉ <abbr title="required" class="required">*</abbr>
										</label>
										<input <?php if (isset($_SESSION['error']['address'])) { ?> style="border-color: red; color: red;" <?php } ?> type="text" value="<?php if (isset($_SESSION['cartData']['infoUser']['address'])) {
																																												echo h($_SESSION['cartData']['infoUser']['address']);
																																											} ?>" placeholder="" id="billing_address_1" name="address" class="input-text ">
										<?php if (isset($_SESSION['error']['address'])) { ?>
											<i style="color: red;">
												<?= implode($_SESSION['error']['address']) ?>
											</i>
										<?php
										} ?>
									</p>
									<div class="clear"></div>
									<p id="billing_email_field" class="form-row form-row-first validate-required validate-email">
										<label class="" for="billing_email">Địa chỉ Email <abbr title="required" class="required">*</abbr>
										</label>
										<input <?php if (isset($_SESSION['error']['email'])) { ?> style="border-color: red; color: red;" <?php } ?> type="text" value="<?php if (isset($_SESSION['cartData']['infoUser']['email'])) {
																																											echo h($_SESSION['cartData']['infoUser']['email']);
																																										} ?>" placeholder="" id="billing_email" name="email" class="input-text ">
										<?php if (isset($_SESSION['error']['email'])) { ?>
											<i style="color: red;">
												<?= implode($_SESSION['error']['email']) ?>
											</i>
										<?php
										} ?>
									</p>

									<p id="billing_phone_field" class="form-row form-row-last validate-required validate-phone">
										<label class="" for="billing_phone">Số điện thoại <abbr title="required" class="required">*</abbr>
										</label>
										<input <?php if (isset($_SESSION['error']['phonenumber'])) { ?> style="border-color: red; color: red;" <?php } ?> type="text" value="<?php if (isset($_SESSION['cartData']['infoUser']['phonenumber'])) {
																																													echo h($_SESSION['cartData']['infoUser']['phonenumber']);
																																												} ?>" placeholder="" id="billing_phone" name="phonenumber" class="input-text input_number" onkeypress='validate(event)' maxlength="10">
										<?php if (isset($_SESSION['error']['phonenumber'])) { ?>
											<i style="color: red;">
												<?= implode($_SESSION['error']['phonenumber']) ?>
											</i>
										<?php
										} ?>
									</p>
									<div class="clear"></div>
									<div class="create-account">
										<p>Chúng tôi sẽ một tài khoản bằng thông tin của bạn. Nếu bạn là khách hàng cũ, vui lòng Đăng nhập ở trên!!!</p>
										<p id="account_password_field" class="form-row validate-required">
											<label class="" for="account_password">Mật khẩu <abbr title="required" class="required">*</abbr>
											</label>

											<input <?php if (isset($_SESSION['error']['password'])) { ?> style="border-color: red; color: red;" <?php } ?> type="password" value="" placeholder="Password" id="account_password" name="password" class="input-text">
											<?php if (isset($_SESSION['error']['password'])) { ?>
												<i style="color: red;">
													<?= implode($_SESSION['error']['password']) ?>
												</i>
											<?php
											} ?>
										</p>
										<div class="clear"></div>
									</div>
								</div>
							</div>
							<div class="col-3">
								<div id="order_review" style="position: relative; display: inline-block;">
									<div id="payment">
										<div class="form-row place-order">
											<a href="/carts">
												<input type="button" data-value="Place order" value="Back" id="place_order" name="woocommerce_checkout_place_order" class="button alt button_back">
											</a>
										</div>
										<div class="clear"></div>
									</div>
								</div>
								<div id="order_review" style="position: relative; float: right;">
									<div id="payment">
										<div class="form-row place-order">
											<input type="submit" data-value="Place order" value="Next" id="place_order" name="woocommerce_checkout_place_order" class="button alt">
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
						</div>
					</form>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php
echo $this->element('NormalUsers/footer');
?>
<?php if (!isset($_SESSION['idUser']) && !isset($_SESSION['hasBack'])) { ?>
	<script>
		swal({
				title: "Bạn có muốn Đăng nhập?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					swal("Xác nhận đến Login!", {
							icon: "success",
						},
						window.location.assign("/login"),
					);
				}
			});

		function validate(evt) {
			var theEvent = evt || window.event;
			// Handle paste
			if (theEvent.type === 'paste') {
				key = event.clipboardData.getData('text/plain');
			} else {
				// Handle key press
				var key = theEvent.keyCode || theEvent.which;
				key = String.fromCharCode(key);
			}
			var regex = /[0-9]|\./;
			if (!regex.test(key)) {
				theEvent.returnValue = false;
				if (theEvent.preventDefault) theEvent.preventDefault();
			}
		}
	</script>
<?php } ?>