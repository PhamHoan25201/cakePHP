<?php
echo $this->element('NormalUsers/header');
?>
<div class="row" style="margin-left: 5px">
	<?= $this->Flash->render() ?>
</div>
<div style="background-color: #f5f5f5;">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row" style="margin: 0 359px;">
			<div class="wrap-login100">

				<?php echo $this->Form->create(null, ['class' => 'login100-form validate-form']); ?>

				<span class="login100-form-title">
					<h3><b>Thay đổi Mật khẩu</b></h3>
				</span>

				<label class="m-t-15" for="myInput1">Mật khẩu cũ:</label>
				<div class="wrap-input100 validate-input" data-validate="Password is required">
					<input id="myInput1" class="input100" type="password" style="padding: 0 30px 0 50px; border: 1px solid;" name="oldpassword" placeholder="Mật khẩu cũ" value="<?=$dataPassword['oldpassword']?>">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
				</div>
				<div style="margin-top: -8px;">
					<?php if (isset($error['errPassword'])) { ?>
						<i style="color: red;">
							<?= implode($error['errPassword']) ?>
						</i>
					<?php } ?>
				</div>
				<label class="m-t-2" for="myInput2">Mật khẩu mới:</label>
				<div class="wrap-input100 validate-input" data-validate="Password is required">
					<input id="myInput2" class="input100" type="password" style="padding: 0 30px 0 50px; border: 1px solid;" name="password" placeholder="Mật khẩu mới" value="<?=$dataPassword['password']?>">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
				</div>
				<div style="margin-top: -8px;">
					<?php if (isset($error['password'])) { ?>
						<i style="color: red;">
							<?= implode($error['password']) ?>
						</i>
					<?php } ?>
				</div>
				<label class="m-t-2" for="myInput3">Nhập lại mật khẩu:</label>
				<div class="wrap-input100 validate-input" data-validate="Password is required">
					<input id="myInput3" class="input100" type="password" style="padding: 0 30px 0 50px; border: 1px solid;" name="newretypepassword" placeholder="Nhập lại mật khẩu" value="<?=$dataPassword['newretypepassword']?>">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
				</div>
				<i style="font-size: 13px;">(*) Sử dụng 8 ký tự trở lên và bao gồm: chữ hoa, chữ thường, số, ký tự đặc biệt. </i>
				<div class="text-left p-t-1 m-l-25">
					<a class="txt2">
						<input id="check" type="checkbox" onclick="myFunction()"><label class="m-l-5" for="check">Hiện mật khẩu</label>
					</a>
				</div>

				<div class="container-login100-form-btn">
					<button type="submit" class="login100-form-btn">
						Xác nhận
					</button>
				</div>

				<div class="text-center p-t-12">
					<a class="txt2" href="/myAccount">
						Quay lại
						<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
					</a>
				</div>
				<?php echo $this->Form->end(); ?>

			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="product-pagination text-center pagination-button">

					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	echo $this->element('NormalUsers/footer');
	?>
	<script>
		function myFunction() {
			var x = document.getElementById("myInput1");
			var y = document.getElementById("myInput2");
			var z = document.getElementById("myInput3");

			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}

			if (y.type === "password") {
				y.type = "text";
			} else {
				y.type = "password";
			}

			if (z.type === "password") {
				z.type = "text";
			} else {
				z.type = "password";
			}
		}
	</script>