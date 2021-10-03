<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Auth\DefaultPasswordHasher;

/**
 * CRUD component
 */
class CRUDComponent extends CommonComponent
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public function initialize(array $config): void
    {
        $this->loadModel(['Users']);
        $this->loadModel('Roles');
        $this->loadModel('Products');
        $this->loadModel('Images');
        $this->loadModel('Categories');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
    }

    public function getUserByID($id){
        $query = $this->Users->find()
            ->where([
                'Users.id' => $id,
            ]);
        return $query->toArray();
    }

    public function getAllRoles($key = null){
        $query = $this->Roles->find()
        ->select([
            'Roles.id',
            'Roles.role_name',
        ]);
        return $query->toArray();
    }

    public function adduser($atribute){
        $user = [];
        $user['username'] = $atribute['username'];
        $user['address'] = $atribute['address'];
        $user['email'] = $atribute['email'];
        $user['phonenumber'] = $atribute['phonenumber'];
        $hashPswdObj = new DefaultPasswordHasher;
        $user['password'] = $hashPswdObj->hash($atribute['password']);
        if($atribute['password'] == ''){
            $user['password'] = '';
        }
        $user['point_user'] = 0;
        $user['role_id'] = $atribute['role_id'];
        $user['avatar'] = 'none.jbg';
        $user['created_date'] = date('Y-m-d h:m:s');
        $user['updated_date'] = date('Y-m-d h:m:s');
        $dataUser = $this->Users->newEntity($user);

        if ($dataUser->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $dataUser->getErrors(),
            ];
        };
        return [
            'result' => 'success',
            'data' => $this->Users->save($dataUser),
        ];
    }

    public function getAllUser($key = null){
        $query = $this->Users->find()
        ->select([
            'Users.id',
            'Users.username',
            'Users.email',
            'Users.phonenumber',
            'Users.address',
            'Users.point_user',
            'Users.role_id',
            'Users.address',
            'Roles.role_name'
        ])
        ->join([
            'table' => 'roles',
            'alias' => 'roles' ,
            'type' => 'left',
            'conditions' => ['Users.role_id = Roles.id']
        ])
        ->order('Users.created_date DESC')
        ;
        return $query;
    }

    // Categories
    public function getAllCategory($key = null){
        $query = $this->Categories->find()
        ->select([
            'Categories.id',
            'Categories.category_name',
            'Categories.del_flag',
        ])
        ->order('Categories.created_date DESC')
        ;
        return $query;
    }

    public function getCategoryByID($id){
        $query = $this->Categories->find()
            ->where([
                'Categories.id' => $id,
            ]);
        return $query->toArray();
    }

    public function addCategory($atribute){
        $category = [];
        $category['category_name'] = $atribute['category_name'];
        $category['created_date'] = date('Y-m-d h:m:s');
        $category['updated_date'] = date('Y-m-d h:m:s');
        $dataCategory = $this->Categories->newEntity($category);

        if ($dataCategory->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $dataCategory->getErrors(),
            ];
        };
        return [
            'result' => 'success',
            'data' => $this->Categories->save($dataCategory),
        ];
    }

    //Products
    public function getAllProduct($key = null){
        $query = $this->Products->find()
        ->select([
            'Products.id',
            'Products.product_name',
            'Products.description',
            'Products.amount_product',
            'Products.point_product',
            'Products.category_id',
            'Categories.category_name'
        ])
        ->join([
            'table' => 'categories',
            'alias' => 'categories' ,
            'type' => 'left',
            'conditions' => ['Products.category_id = Categories.id']
        ])
        ->order('Products.created_date DESC')
        ->contain(['Images']);
        return $query;
    }

    public function addproduct($atribute){
        $product = [];
        $product['product_name'] = $atribute['product_name'];
        $product['description'] = $atribute['description'];
        $product['amount_product'] = $atribute['amount_product'];
        $product['point_product'] = $atribute['point_product'];
        $product['category_id'] = $atribute['category_id'];
        $product['created_date'] = date('Y-m-d h:m:s');
        $product['updated_date'] = date('Y-m-d h:m:s');
        $dataProduct = $this->Products->newEntity($product);
        // dd($dataProduct);

        if ($dataProduct->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $dataProduct->getErrors(),
            ];
        };
        return [
            'result' => 'success',
            'data' => $this->Products->save($dataProduct),
        ];
    }

    public function getProductByID($id){
        $query = $this->Products->find()
            ->where([
                'Products.id' => $id,
            ]);
        return $query->toArray();
    }

    //Search
    public function getSearch($key){

        $query = $this->Products->find()
        ->select([
            'Products.id',
            'Products.product_name',
            'Products.description',
            'Products.amount_product',
            'Products.point_product',
            'Products.category_id',
            'Categories.category_name'
        ])
        ->join([
            'table' => 'categories',
            'alias' => 'categories' ,
            'type' => 'left',
            'conditions' => ['Products.category_id = Categories.id']
        ])
        ->order('Products.created_date DESC')
        ->contain(['Images'])
        ->where([
                'Products.product_name like' => '%'. $key .'%',
        ]);
        return $query;
    }

    //Orders
    public function getAllOrder($key = null){
        $query = $this->Orderdetails->find()
        ->select([
            'Orderdetails.id',
            'Orderdetails.quantity_orderDetails',
            'Orderdetails.amount_orderDetails',
            'Orderdetails.point_orderDetail',
            'Orderdetails.product_id',
            'Products.product_name',
            'Orderdetails.order_id ',
            'Orders.email ',
            'Orders.phonenumber ',
            'Orders.address ',
            'Orders.total_point',
            'Orders.total_quantity',
            'Orders.total_amount',
            'Orders.status',
            'Orders.user_id',
            'Users.username',
        ])
        ->join([
            'table' => 'products',
            'alias' => 'products' ,
            'type' => 'left',
            'conditions' => ['Orderdetails.product_id = Products.id']
        ])
        ->join([
            'table' => 'orders',
            'alias' => 'orders' ,
            'type' => 'left',
            'conditions' => ['Orderdetails.order_id = Orders.id']
        ])
        ->join([
            'table' => 'users',
            'alias' => 'users' ,
            'type' => 'left',
            'conditions' => ['Orders.user_id= Users.id']
        ])
        ->order('Orderdetails.created_date DESC');
        return $query;
    }

    //Search Orders
    public function getSearchOrder($key){

        $query = $this->Users->find()
            ->where([
                'Users.username like' => '%'. $key .'%',
            ]);
        return $query;
    }

    public function addorder($atribute){
        $product = [];
        $product['product_name'] = $atribute['product_name'];
        $product['description'] = $atribute['description'];
        $product['amount_product'] = $atribute['amount_product'];
        $product['point_product'] = $atribute['point_product'];
        $product['category_id'] = $atribute['category_id'];
        $product['created_date'] = date('Y-m-d h:m:s');
        $product['updated_date'] = date('Y-m-d h:m:s');
        $dataProduct = $this->Products->newEntity($product);
        // dd($dataProduct);

        if ($dataProduct->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $dataProduct->getErrors(),
            ];
        };
        return [
            'result' => 'success',
            'data' => $this->Products->save($dataProduct),
        ];
    }

    public function getOrderByID($id){
        $query = $this->Products->find()
            ->where([
                'Products.id' => $id,
            ]);
        return $query->toArray();
    }
}