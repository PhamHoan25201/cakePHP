<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
/**
 * Users Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    //component
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Data');
       
    }

    public function index()
    {
        // $users = TableRegistry::get('users');
        //  $query = $users->find();
        //  $this->set('results',$query);
         return $this->redirect(['controller'=>'/', 'action' => 'index']);
    }

    // LOGIN
    public function login(){
        if($this->request->is('post')) {
            $con = mysqli_connect("localhost", "root", "", "cakephp");

            $email = $this->request->getData('email');
            $hashPswdObj = new DefaultPasswordHasher;
            $password = $this->request->getData('password');
            $this->getTableLocator()->get('users');
            $passworDB = $this->{'Data'}->getPws($email);
            $checkPassword =  $hashPswdObj->check($password, $passworDB[0]['password'] );
            // checkpass bằng mã hash
            if($checkPassword){
                $query = "SELECT* from users where email = '$email'";
                $result = mysqli_query($con, $query);
                $row_user = mysqli_fetch_assoc($result);
                if(mysqli_num_rows($result) > 0){
                    $idUser = $row_user['id'];
                    $username = $row_user['username'];
                    $session = $this->request->getSession();
                    $session->write('idUser', $idUser);
                    $session->write('username', $username);
                    return $this->redirect(['action' => 'index']);
                 } else {
                 $this->Flash->error('Your username or password is incorrect.');
                 }
            }
        }

    }

    public function logout(){
        $session = $this->request->getSession();
        $session->destroy();
        return $this->redirect(['action' => 'index']);
    }

    //Register (sau)
    public function register(){

    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $user = $this->Users->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $user = $this->Users->patchEntity($user, $this->request->getData());
    //         if ($this->Users->save($user)) {
    //             $this->Flash->success(__('The user has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The user could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('user'));
    // }

    public function add(){
        $rolesTable = TableRegistry::getTableLocator()->get('Roles')->find()->all();

        if($this->request->is('post')){
            $atribute = $this->request->getData();
            $this->render();
            $sc = $this->Data->createUsers($atribute);

            if($sc['result'] == "success")
            {
                return $this->redirect(['action' => 'index']);
            }

        }
        $this->set(compact('rolesTable'));
    }


    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id){
        if($this->request->is('post')){
           $username = $this->request->getData('username');
           $password = $this->request->getData('password');
           $users_table = TableRegistry::get('users');
           $users = $users_table->get($id);
           $users->username = $username;
           $users->password = $password;
           if($users_table->save($users))
           echo "User is udpated";
           $this->setAction('index');
        } else {
           $users_table = TableRegistry::get('users')->find();
           $users = $users_table->where(['id'=>$id])->first();
           $this->set('username',$users->username);
           $this->set('password',$users->password);
           $this->set('id',$id);
        }
     }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $user = $this->Users->get($id);
    //     if ($this->Users->delete($user)) {
    //         $this->Flash->success(__('The user has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The user could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    public function delete($id){
        $users_table = TableRegistry::get('users');
        $users = $users_table->get($id);
        $users_table->delete($users);
        echo "User deleted successfully.";
        return $this->redirect(['action' => 'index']);
     }

     
}
