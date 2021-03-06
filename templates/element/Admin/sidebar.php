<div id="sidebar" class='active'>
	<div class="sidebar-wrapper active">
		<div class="sidebar-header">
			<?php
			echo $this->Html->image("Admin/logo.svg", [
				"alt" => "logo",
				'url' => '/admin'
			]);
			?>
		</div>
		<div class="sidebar-menu">
			<ul class="menu">
				<li class='sidebar-title'>Main Menu</li>
				<li class="sidebar-item ">
					<a href="/" class='sidebar-link'>
						<i data-feather="home" width="20"></i>
						<span>Trang Home</span>
					</a>
				</li>

				<li class="sidebar-item ">
					<a href="/admin" class='sidebar-link'>
						<i data-feather="home" width="20"></i>
						<span>Thống Kê</span>
					</a>
				</li>

				<li class='sidebar-title'>Quản Lý</li>

				<?php if ($_SESSION['flag'] == 2) { ?>
					<li class="sidebar-item  has-sub">
						<a href="#" class='sidebar-link'>
							<i data-feather="file-text" width="20"></i>
							<span>Quản lý Users</span>
						</a>
						<ul class="submenu ">
							<li>
								<a href="<?= $this->Url->build('admin/list-user', ['fullBase' => true]) ?>">List User</a>
							</li>
							<li>
								<a href="<?= $this->Url->build('admin/add-user', ['fullBase' => true]) ?>">Add User</a>
							</li>

						</ul>
					</li>
				<?php } ?>

				<li class="sidebar-item  has-sub">
					<a href="#" class='sidebar-link'>
						<i data-feather="file-text" width="20"></i>
						<span>Quản lý danh mục</span>
					</a>
					<ul class="submenu ">
						<li>
							<a href="<?= $this->Url->build('admin/list-categories', ['fullBase' => true]) ?>">Danh sách danh mục</a>
						</li>

					</ul>
				</li>

				<li class="sidebar-item  has-sub">
					<a href="#" class='sidebar-link'>
						<i data-feather="file-text" width="20"></i>
						<span>Quản lý sản phẩm </span>
					</a>
					<ul class="submenu ">
						<li>
							<a href="<?= $this->Url->build('admin/list-products', ['fullBase' => true]) ?>">Danh sách sản phẩm</a>
						</li>
					</ul>
				</li>

				<li class="sidebar-item  has-sub">
					<a href="#" class='sidebar-link'>
						<i data-feather="file-text" width="20"></i>
						<span>Quản lý Đơn hàng</span>
					</a>
					<ul class="submenu ">
						<li>
							<a href="<?= $this->Url->build('admin/list-orders', ['fullBase' => true]) ?>">Danh sách Đơn hàng</a>
						</li>
					</ul>
				</li>

				<li class="sidebar-item  has-sub">
					<a href="#" class='sidebar-link'>
						<i data-feather="file-text" width="20"></i>
						<span>Quản lý Nhập</span>
					</a>
					<ul class="submenu ">
						<li>
							<a href="<?= $this->Url->build('admin/input-product', ['fullBase' => true]) ?>">Nhập Kho</a>
						</li>

						<li>
							<a href="<?= $this->Url->build('admin/list-inventory', ['fullBase' => true]) ?>">Danh sách tồn kho</a>
						</li>

						<li>
							<a href="<?= $this->Url->build('admin/list-history', ['fullBase' => true]) ?>">Lịch sử Nhập</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
	</div>
</div>