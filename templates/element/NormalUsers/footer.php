<div class="footer-top-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">

			<div class="col-md-4 col-sm-6">
				<div class="footer-about-us">
					<h2>V<span>erTu</span></h2>
					<p>Hệ thống bán lẻ điện thoại di động, smartphone, máy tính bảng, tablet, laptop, phụ kiện, smartwatch, đồng hồ chính hãng mới nhất, giá tốt!!!</p>

				</div>
			</div>

			<div class="col-md-4 col-sm-6">
				<div class="footer-menu">
					<h2 class="footer-wid-title">User Navigation </h2>
					<ul>
						<li>My account</li>
						<li>Order history</li>
						<li>Wishlist</li>
						<li>Vendor contact</li>
						<li>Front page</li>
					</ul>
				</div>
			</div>

			<div class="col-md-4 col-sm-6">
				<div class="footer-menu">
					<h2 class="footer-wid-title">Categories</h2>
					<ul>
						<li>Mobile Phone</li>
						<li>Home accesseries</li>
						<li>LED TV</li>
						<li>Computer</li>
						<li>Gadets</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div> <!-- End footer top area -->

<div class="footer-bottom-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="copyright">
					<p style="text-align: center">&copy; Phạm Văn Hoàn - 19CDTH41 - Trường Cao Đẳng Công nghiệp Huế </p>
				</div>
			</div>
		</div>
	</div>
</div> <!-- End footer bottom area -->

<!-- Latest jQuery form server -->
<script src="https://code.jquery.com/jquery.min.js"></script>

<!-- Bootstrap JS form CDN -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!-- jQuery sticky menu -->
<script src="../../js/NormalUsers/owl.carousel.min.js"></script>
<script src="../../js/NormalUsers/jquery.sticky.js"></script>

<!-- jQuery easing -->
<script src="../../js/NormalUsers/jquery.easing.1.3.min.js"></script>

<!-- Main Script -->
<script src="../../js/NormalUsers/main.js"></script>
<!-- Toast Script -->
<script src="../../js/NormalUsers/toast.js"></script>
<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type='text/javascript'>
	checkCtrl = false
	$('*').keydown(function(e) {
		if (e.keyCode == '17') {
			checkCtrl = false
		}
	}).keyup(function(ev) {
		if (ev.keyCode == '17') {
			checkCtrl = false
		}
	}).keydown(function(event) {
		if (checkCtrl) {
			if (event.keyCode == '85') {
				return false;
			}
		}
	})
</script>

<!-- Slider -->
<script type="text/javascript" src="js/NormalUsers/bxslider.min.js"></script>
<script type="text/javascript" src="js/NormalUsers/script.slider.js"></script>

<!--====================================TEST===========================================================-->
<script src="vendor/Login/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/Login/bootstrap/js/popper.js"></script>
<script src="vendor/Login/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/Login/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/Login/tilt/tilt.jquery.min.js"></script>
<script>
	$('.js-tilt').tilt({
		scale: 1.1
	})
</script>
<!--=====================================ENDTEST==========================================================-->
<script src="js/main.js"></script>
</body>

</html>