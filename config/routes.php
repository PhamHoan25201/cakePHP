<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {

	//NormalUser
	$builder->connect('/', ['controller' => 'NormalUsers', 'action' => 'index']);

	//Order
	$builder->connect('/addCart', ['controller' => 'NormalUsers', 'action' => 'addCart']);
	$builder->connect('/reduceQuantity', ['controller' => 'NormalUsers', 'action' => 'reduceQuantity']);
	$builder->connect('/removeProduct', ['controller' => 'NormalUsers', 'action' => 'removeProduct']);
	$builder->connect('/carts', ['controller' => 'NormalUsers', 'action' => 'informationCart']);

	//Information Customer
	$builder->connect('/infoCustomer', ['controller' => 'NormalUsers', 'action' => 'infoCustomer']);

	//X??c nh???n ?????t h??ng
	$builder->connect('/confirmOrder', ['controller' => 'NormalUsers', 'action' => 'confirmOrder']);

	//Add v??o DB cho ?????t h??ng ???? login
	$builder->connect('/addOrders', ['controller' => 'NormalUsers', 'action' => 'addOrders']);

	//Ho??n th??nh ?????t h??ng
	$builder->connect('/completeOrder', ['controller' => 'NormalUsers', 'action' => 'completeOrder']);

	//Input - Order none Login
	$builder->connect('/input', ['controller' => 'NormalUsers', 'action' => 'inputUser']);

	//X??c nh???n ????n h??ng kh??ng Login
	$builder->connect('/confirm', ['controller' => 'NormalUsers', 'action' => 'confirm']);

	//Add v??o DB cho ?????t h??ng kh??ng login
	$builder->connect('/addOrdersNoneLogin', ['controller' => 'NormalUsers', 'action' => 'addOrdersNoneLogin']);

	//Th??ng tin c?? nh??n show ??? trang index
	$builder->connect('/myAccount', ['controller' => 'NormalUsers', 'action' => 'myAccount']);

	//Edit th??ng tin c?? nh??n/edit-account/
	$builder->connect('/edit-account/:id', ['controller' => 'NormalUsers', 'action' => 'editAccount'], ["pass" => ["id"]]);

	//Show Danh m???c s???n ph???m
	$builder->connect('/view-category/:id', ['controller' => 'NormalUsers', 'action' => 'viewProductByCategory'], ["pass" => ["id"]]);

	//Show chi ti???t s???n ph???m
	$builder->connect('/details-product/:id', ['controller' => 'NormalUsers', 'action' => 'detailsProduct'], ["pass" => ["id"]]);

	// L???ch s??? mua h??ng
	$builder->connect('/history-orders', ['controller' => 'NormalUsers', 'action' => 'historyOrders']);
	$builder->connect('/details-order/:id', ['controller' => 'NormalUsers', 'action' => 'orderDetails'], ["pass" => ["id"]]);

	//Page Error
	$builder->connect('/pageError', ['controller' => 'NormalUsers', 'action' => 'pageError']);

	//Authexs
	$builder->connect('/auth', ['controller' => 'Authexs', 'action' => 'index']);
	$builder->connect('/login', ['controller' => 'Authexs', 'action' => 'login'], ['_name' => 'login']);
	$builder->connect('/register', ['controller' => 'Authexs', 'action' => 'register']);
	$builder->connect('/logout', ['controller' => 'Authexs', 'action' => 'logout']);

	//Thay ?????i m???t kh???u
	$builder->connect('/change-password', ['controller' => 'Authexs', 'action' => 'changePassword']);

	//Qu??n m???t kh???u
	$builder->connect('/forgotPassword', ['controller' => 'Authexs', 'action' => 'forgotPassword']);

	//Set l???i m???t kh???u
	$builder->connect('/resetPassword/:token',['controller'=>'Authexs','action'=>'resetPassword'], ["pass" => ["token"]]);

	$builder->connect('pages/*', ['controller' => 'Pages', 'action' => 'display']);

	$builder->fallbacks();
});

Router::prefix('admin', function (RouteBuilder $routes) {
	$routes->connect('/', ['controller' => 'Admin', 'action' => 'index']);

	//CRUD Users
	$routes->connect('/add-user', ['controller' => 'Users', 'action' => 'addUser']);
	$routes->connect('/edit-user/:id', ['controller' => 'Users', 'action' => 'editUser'], ["pass" => ["id"]]);
	$routes->connect('/delete-user/:id', ['controller' => 'Users', 'action' => 'deleteUser'], ["pass" => ["id"]]);
	$routes->connect('/opent-user/:id', ['controller' => 'Users', 'action' => 'opentUser'], ["pass" => ["id"]]);
	$routes->connect('/list-user', ['controller' => 'Users', 'action' => 'listUsers']);

	//CRUD Danh m???c s???n ph???m
	$routes->connect('/add-category', ['controller' => 'Categories', 'action' => 'addCategory']);
	$routes->connect('/edit-category/:id', ['controller' => 'Categories', 'action' => 'editCategory'], ["pass" => ["id"]]);
	$routes->connect('/delete-category/:id', ['controller' => 'Categories', 'action' => 'deleteCategory'], ["pass" => ["id"]]);
	$routes->connect('/list-categories', ['controller' => 'Categories', 'action' => 'listCategories']);

	//CRUD Danh s??ch s???n ph???m
	$routes->connect('/add-product', ['controller' => 'Products', 'action' => 'addProduct']);
	$routes->connect('/edit-product/:id', ['controller' => 'Products', 'action' => 'editProduct'], ["pass" => ["id"]]);
	$routes->connect('/delete-product/:id', ['controller' => 'Products', 'action' => 'deleteProduct'], ["pass" => ["id"]]);
	$routes->connect('/list-products', ['controller' => 'Products', 'action' => 'listProducts']);

	//CRUD Danh s??ch h??nh ???nh
	$routes->connect('/add-image', ['controller' => 'Images', 'action' => 'addImages']);
	$routes->connect('/edit-image/:id', ['controller' => 'Images', 'action' => 'editImage'], ["pass" => ["id"]]);
	$routes->connect('/delete-image/:id', ['controller' => 'Images', 'action' => 'deleteImage'], ["pass" => ["id"]]);
	$routes->connect('/list-images', ['controller' => 'Images', 'action' => 'listImages']);

	//CRUD Danh s??ch order
	$routes->connect('/add-order', ['controller' => 'Orders', 'action' => 'addOrder']);
	$routes->connect('/edit-order/:id', ['controller' => 'Orders', 'action' => 'editOrder'], ["pass" => ["id"]]);
	$routes->connect('/delete-order/:id', ['controller' => 'Orders', 'action' => 'deleteOrder'], ["pass" => ["id"]]);
	$routes->connect('/list-orders', ['controller' => 'Orders', 'action' => 'listOrders']);

	//Duy???t ????n v?? Chi ti???t ????n
	$routes->connect('/details-order/:id', ['controller' => 'Orders', 'action' => 'orderDetails'], ["pass" => ["id"]]);
	$routes->connect('/confirm-order/:id', ['controller' => 'Orders', 'action' => 'confirmOrder'], ["pass" => ["id"]]);

	//Qu???n l?? nh???p kho
	$routes->connect('/input-product', ['controller' => 'HistoryInput', 'action' => 'inputProduct']);
	$routes->connect('/input-product/:id', ['controller' => 'HistoryInput', 'action' => 'inputProduct'], ["pass" => ["id"]]);
	$routes->connect('/list-history', ['controller' => 'HistoryInput', 'action' => 'listHistory']);
	$routes->connect('/list-inventory', ['controller' => 'HistoryInput', 'action' => 'listInventory']);
	$routes->connect('/inventory/export', ['controller' => 'Admin', 'action' => 'exportInventory']);

	$routes->fallbacks(DashedRoute::class);
});
