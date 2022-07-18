<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\EventInterface;
use Cake\Routing\Router;

class AuthexsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('Data');
		$this->loadComponent('CRUD');
		$this->loadComponent('Mail');
		$this->loadModel("Users");
	}
	public function beforeRender(EventInterface $event)
	{
		$dataCategories = $this->{'Data'}->getCategory();
		$dataProducts = $this->{'Data'}->getAllProducts();
		$dataSlideImages = $this->{'Data'}->getSlideImage();
		$dataNewsProducts = $this->{'Data'}->getNewsProduct();
		$session = $this->request->getSession();

		if ($session->check('idUser')) {
			$idUsers = $session->read('idUser');
			$dataNameForUser = $this->{'Data'}->getInfoUser($idUsers);
			$this->set(compact('dataNameForUser'));
		}

		$this->set(compact('dataProducts', 'dataSlideImages', 'dataNewsProducts', 'dataCategories'));
	}

	public function beforeFilter(EventInterface $event)
	{
		$session = $this->request->getSession();
		if ($session->check('flag')) {
			$idUser = $session->read('idUser');
			$check = $this->{'CRUD'}->checkUserLock($idUser);
			if(count($check) < 1){
				$session->destroy();
				$this->Flash->error(__(ERROR_LOCK_ACCOUNT));
				return $this->redirect(Router::url(['_name' => NAME_LOGIN]));
			}
		}
	}

	public function index()
	{
		return $this->redirect(['controller' => 'NormalUsers', 'action' => NORMALUSER_INDEX]);
	}

	public function login()
	{
		$session = $this->request->getSession();
		if ($session->check('flag')) {
			return $this->redirect(['action' => AUTH_INDEX]);
		}
		if ($this->request->is('post')) {
			$email = $this->request->getData('email');
			$password = $this->request->getData('password');

			//Lưu oldValue
			$session->write('email', $email);
			$session->write('password', $password);

			// Check rỗng và check đổi name F12
			if ($email == null || $password == null) {
				$this->Flash->error(ERROR_FULL_INFOR);
				return $this->redirect(['action' => '']);
			}

			$atribute = $this->request->getData();
			$hashPswdObj = new DefaultPasswordHasher;
			$passwordDB = $this->{'Data'}->getPws($email);

			//Check tài khoản bị khóa
			$delFlag = $this->{'CRUD'}->checkDelFlagByEmail($email);
			if (count($delFlag) > 0) {
				$this->Flash->error(ERROR_LOCK_ACCOUNT);
				return $this->redirect(['action' => '']);
			}

			//Check email tồn tại
			$dataUserArr = $this->{'CRUD'}->getUsersByEmailArr($email);
			if (count($dataUserArr) < 1) {
				$this->Flash->error(ERROR_EMAIL_EMPTY);
				return $this->redirect(['action' => '']);
			} else {
				$checkPassword =  $hashPswdObj->check($password, $passwordDB[0]['password']);

				// checkpass bằng mã hash
				if ($checkPassword) {
					$result = $this->{'Data'}->checklogin($atribute);
					if (count($result) > 0) {
						$idUser = $result[0]['id'];
						$username = $result[0]['username'];
						$session = $this->request->getSession();
						$session->write('idUser', $idUser);
						$session->write('username', $username);

						//Check quyền gắn cờ
						if ($result[0]['role_id'] == 1) {
							$flag = 1;
						} elseif ($result[0]['role_id'] == 2) {
							$flag = 2;
						} else {
							$flag = 3;
						}
						$session->write('flag', $flag);

						//Check nếu là admin hoặc employee thì đi thẳng đến admin
						if($flag == 2 || $flag == 3){
							return $this->redirect(URL_INDEX_ADMIN);
						}else{
							return $this->redirect(['action' => AUTH_INDEX]);
						}
					} else {
						$this->Flash->error(ERROR_EMAIL_PWS_INCORRECT);
					}
				} else {
					$this->Flash->error(ERROR_EMAIL_PWS_INCORRECT);
				}
			}
		}
	}

	//Logout
	public function logout()
	{
		$session = $this->request->getSession();
		$session->destroy();
		return $this->redirect(['action' => AUTH_INDEX]);
	}

	//Đăng ký
	public function register()
	{
		if ($this->request->is('post')) {
			$atribute = $this->request->getData();

			$session = $this->request->getSession();
			$dataUser = $this->{'CRUD'}->register($atribute);
			$checkmail = $this->{'Data'}->checkmail($atribute);

			$session->write('infoUser', $atribute);
			$session->write('email', $atribute['email']);
			$session->write('password', $atribute['password']);

			// check retype Password
			if (!($atribute['password'] == $atribute['retypePassword'])) {
				$error['retypePassword'] = [ERROR_PASSWORD_NOT_MATCH];
				$session->write('error', $error);
				$this->redirect(['action' => '']);
			}else{
				if ($dataUser['result'] == "invalid") {
					$error = $dataUser['data'];
					$session->write('error', $error);
				} else {
					if ($session->check('error')) {
						$session->delete('error');
					}

					//Hash Pws
					$hashPswdObj = new DefaultPasswordHasher;
					$dataUser['data']['password'] = $hashPswdObj->hash($dataUser['data']['password']);

					if ($dataUser['data']['password'] == '') {
						$dataUser['data']['password'] = '';
					}
					$this->Users->save($dataUser['data']);
					$this->redirect(['action' => AUTH_LOGIN]);
					$this->Flash->success(__(SUCCESS_ACCOUNT));
					if ($session->check('infoUser')) {
						$session->delete('infoUser');
					}
				}
			}
		}
	}

	//Thay đổi mật khẩu
	public function changePassword()
	{
		$session = $this->request->getSession();
		$data = null;
		if (!$session->check('flag')) {
			return $this->redirect(['action' => AUTH_INDEX]);
		}
		if ($this->request->is('post')) {
			$atribute = $this->request->getData();
			if (($atribute['oldpassword'] == '') || ($atribute['password'] == '') || ($atribute['newretypepassword'] == '')) {
				$this->Flash->error(__(ERROR_FULL_INFOR));
				$data = $atribute;
			} else {
				// check retype Password
				if (!($atribute['password'] == $atribute['newretypepassword'])) {
					$this->Flash->error(__(ERROR_PASSWORD_NOT_MATCH));
					$data = $atribute;
				} else {
					if(($atribute['password'] == $atribute['oldpassword'])){
						$this->Flash->error(__(ERROR_PASSWORD_NOT_CHANGED));
						$data = $atribute;
					}else{
						$idUser = $session->read('idUser');
						$dataUser = $this->{'CRUD'}->getUsersByID($idUser);
						$hashPswdObj = new DefaultPasswordHasher;
						$checkPassword =  $hashPswdObj->check($atribute['oldpassword'], $dataUser['password']);
						if ($checkPassword) {
							$user = $this->Users->patchEntity($dataUser, $atribute);
							if ($user->hasErrors()) {
								$error = $user->getErrors();
								$this->set('error', $error);
								$data = $atribute;
							} else {
								$newpass = $hashPswdObj->hash($atribute['password']);
								$user->password = $newpass;
								if ($this->Users->save($user)) {
									$this->Flash->success(SUCCESS_PASSWORD_CHANGED);
								} else {
									$this->Flash->error(__(ERROR_RETRY));
									$data = $atribute;
								}
							}
						} else {
							$error['errPassword'] = [ERROR_PWS_INCORRECT] ;
							$this->set('error', $error);
							$data = $atribute;
						}
					}
				}
			}
		}

		$this->set('dataPassword', $data);
	}

	//Quên mật khẩu
	public function forgotPassword()
	{
		if ($this->request->is('post')) {
			$session = $this->request->getSession();
			$email = $this->request->getData('email');
			$mytoken = \Cake\Utility\Security::hash(\Cake\Utility\Security::randomBytes(25));

			$dataUser = $this->{'CRUD'}->getUsersByEmail($email);
			$dataUserArr = $this->{'CRUD'}->getUsersByEmailArr($email);

			//Check rỗng
			if ($email == "") {
				$error = [];
				$error['email_null'] = [ERROR_NOT_INPUT_EMAIL];
				$session->write('error_forgot', $error);
				return $this->redirect(['action' => '']);
			} else {
				if ($session->check('error_forgot')) {
					$session->delete('error_forgot');
				}
			}

			// Checkemail tồn tài chưa
			if (count($dataUserArr) < 1) {
				$error = [];
				$error['email'] = [ERROR_EMAIL_EMPTY];
				$session->write('error_forgot', $error);
				return $this->redirect(['action' => '']);
			} else {
				// Ở phần này có 2 kiểu làm quên password
				$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
				$randompws = substr(str_shuffle($string), 0, 8);

				$hasher = new DefaultPasswordHasher();
				$mypass = $hasher->hash($randompws);
				$dataUser->password =  $mypass;
				// $dataUser->token =  $mytoken;

				if ($session->check('error_forgot')) {
					$session->delete('error_forgot');
					if ($this->Users->save($dataUser)) {

						//Lưu và xóa Session
						$session->write('email', $email);
						if($session->check('password')){
							$session->delete('password');
						}

						$this->Flash->success('Mật khẩu của bạn đã được gửi về email (' . $email . '), vui lòng kiểm tra');
						$to = $email;
						$toAdmin = 'phamhoan020501@gmail.com';
						$subject = 'Reset Password';
						$message = 'Mật khẩu của bạn là:' . $randompws . '';
						$errSendMail = $this->{'Mail'}->send_mail($to, $toAdmin, $subject, $message);
						if ($errSendMail == false) {
							$this->redirect(['action' => AUTH_LOGIN]);
						}
					} else {
						$this->Flash->error(__(ERROR_RETRY));
					}
				} else {
					if ($this->Users->save($dataUser)) {

						//Lưu và xóa Session
						$session->write('email', $email);
						if($session->check('password')){
							$session->delete('password');
						}

						$this->Flash->success('Mật khẩu của bạn đã được gửi về email (' . $email . '), vui lòng kiểm tra');
						$to = $email;
						$toAdmin = MAIL_ADMIN;
						$subject = 'Reset Password';

						$message = '
						<!DOCTYPE html>
						<html>
						<head>
							<title></title>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<meta name="viewport" content="width=device-width, initial-scale=1">
							<meta http-equiv="X-UA-Compatible" content="IE=edge" />
							<style type="text/css">
								body,
								table,
								td,
								a {
									-webkit-text-size-adjust: 100%;
									-ms-text-size-adjust: 100%;
								}
								table,
								td {
									mso-table-lspace: 0pt;
									mso-table-rspace: 0pt;
								}
								img {
									-ms-interpolation-mode: bicubic;
								}
								img {
									border: 0;
									height: auto;
									line-height: 100%;
									outline: none;
									text-decoration: none;
								}
								table {
									border-collapse: collapse !important;
								}
								body {
									height: 100% !important;
									margin: 0 !important;
									padding: 0 !important;
									width: 100% !important;
								}
								a[x-apple-data-detectors] {
									color: inherit !important;
									text-decoration: none !important;
									font-size: inherit !important;
									font-family: inherit !important;
									font-weight: inherit !important;
									line-height: inherit !important;
								}
								@media screen and (max-width: 480px) {
									.mobile-hide {
										display: none !important;
									}
									.mobile-center {
										text-align: center !important;
									}
								}
								div[style*="margin: 16px 0;"] {
									margin: 0 !important;
								}
							</style>
						<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">
							<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Open Sans, Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
								Bạn đã đặt hàng thành công trên Website: Vertu.vn
							</div>
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
											<tr>
												<td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#ee5057">
													<div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
															<tr>
																<td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 36px; font-weight: 800; line-height: 48px;" class="mobile-center">
																	<h1 style="font-size: 36px; font-weight: 800; margin: 0; color: #ffffff;">VERTU</h1>
																</td>
															</tr>
														</table>
													</div>
													<div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;" class="mobile-hide">
														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
															<tr>
																<td align="right" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;">
																	<table cellspacing="0" cellpadding="0" border="0" align="right">
																		<tr>
																			<td style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;">
																				<p style="font-size: 18px; font-weight: 400; margin: 0; color: #ffffff;"><a href="' . DOMAIN . '" target="_blank" style="color: #ffffff; text-decoration: none;">Shop &nbsp;</a></p>
																			</td>
																			<td style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 24px;"> <a href="' . DOMAIN . '" target="_blank" style="color: #ffffff; text-decoration: none;"><img src="https://img.icons8.com/color/48/000000/small-business.png" width="27" height="23" style="display: block; border: 0px;" /></a> </td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</div>
												</td>
											</tr>
											<tr>
												<td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
													<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
														<tr>
															<td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;"> <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png" width="125" height="120" style="display: block; border: 0px;" /><br>
																<h2 style="font-size: 30px; font-weight: 700; line-height: 36px; color: #333333; margin: 0;"> Xin chào ' . $email . '. Cảm ơn bạn đã truy cập vào VerTu.vn! </h2>
															</td>
														</tr>
														<tr>
															<td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
																<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> VerTu.vn rất hân hạnh đồng hành cùng bạn: </p>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-top: 20px;">
																<table cellspacing="0" cellpadding="0" border="0" width="100%">
																	<tr>
																		<td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; line-height: 24px; padding: 10px;"> Thông tin Khách hàng </td>
																		<td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">  </td>
																	<tr>
																		<td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">Mật khẩu mới của bạn là:  </td>
																		<td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> ' . $randompws . ' </td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
											<tr>
												<td align="center" style=" padding: 35px; background-color: #ff7361;" bgcolor="#1b9ba3">
													<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
														<tr>
															<td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
																<h2 style="font-size: 24px; font-weight: 700; line-height: 30px; color: #ffffff; margin: 0;"> VerTu.vn đang có nhiều ưu đãi dành cho bạn. Truy cập ngay!!! </h2>
															</td>
														</tr>
														<tr>
															<td align="center" style="padding: 25px 0 15px 0;">
																<table border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="center" style="border-radius: 5px;" bgcolor="#66b3b7"> <a href="' . DOMAIN . '" target="_blank" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #F44336; padding: 15px 30px; border: 1px solid #F44336; display: block;">Truy Cập</a> </td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</body>
                     </html>';
						// $message = 'Hello'.$email.'<br/>Hãy click vào link dưới để reset mật khẩu<br/><br/> <a href="http://test.com:8080/resetpassword/'.$mytoken.'">Reset</a>';
						$errSendMail = $this->{'Mail'}->send_mail($to, $toAdmin, $subject, $message);
						if ($errSendMail == false) {
							$this->redirect(['action' => AUTH_LOGIN]);
						}
					} else {
						$this->Flash->error(__(ERROR_RETRY));
					}
				}
			}
		}
	}

	public function resetPassword($token = null){
		if($this->request->is('post')){
			$hasher = new DefaultPasswordHasher();
			$mypass = $hasher->hash($this->request->getData('password'));
  
			$userTable = TableRegistry::get('Users');
			$user = $userTable->find('all')->where(['token'=>$token])->first();
			$user->password = $mypass;
			if($userTable->save($user)){
				return $this->redirect(['action'=>'AUTH_LOGIN']);
			}
  
		}else{
			$this->set('token', $token);
		}
  
	}
}
