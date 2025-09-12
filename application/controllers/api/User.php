<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require APPPATH . 'libraries/REST_Controller.php';
class User extends REST_Controller
{
     private $salt = 'c1!s4vFdxM8DdmOj0lvxp3cFwQx';
    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->load->helper('url');
        $this->load->model('Api_model');
        
        $checkToken = $this->checkForToken();
        if(!$checkToken) { die(); }
    }
    /** User Register **/
    public function userRegister_post()
    {
        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');
        $input = $this->input->post();
        $auth = date('Ymdhis') . rand(10, 9999);
        $auth = md5($auth);
        $input['token'] = $auth;

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $name = removeAllSpecialCharcter($data['name']);
        $email = $data['email'];
        $varified_user = 'No';
        $password = $data['password'];
        $mobile = removeAllSpecialCharcter($data['phone']);


        if ($name == '') {

        } elseif (!is_numeric($mobile) || strlen($mobile) != 10) {
            $return['message'] = 'Mobile number is not valid';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) < 10) {
            $return['message'] = 'Email is not valid';
        } 
		elseif ($password == '' || strlen($password) < 6) {
            $return['message'] = 'Please enter a Password of 6 or more characters';
        }else{
            $checkUser = $this->Api_model->getRecordByColumn('mobile',$mobile,'users','mobile');
            if($checkUser){
                $return['message'] = 'Phone number already exists';   
            }
            else{
				$hashed_password = md5($password);
                $addInfo = array('name' => $name, 'email' => $email, 'mobile' => $mobile, 'token'=>$auth, 'varified_user'=>$varified_user, 'password'=>$hashed_password);
                $this->Api_model->add_data_in_table($addInfo, 'users');
                $return = array('token'=>$auth);
                //$return['result'] = '';
                $return['status'] = 'done';
                $return['message'] = 'User registered successfully!';
            }
        }
        $this->response($return, REST_Controller::HTTP_OK);
    }


    public function resetPassword_post()
    {
        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $encoded_token = isset($data['token']) ? trim($data['token']) : '';
        $new_password = isset($data['password']) ? trim($data['password']) : '';

        if ($encoded_token == '') {
            $return['message'] = 'Invalid or missing token';
        } elseif ($new_password == '' || strlen($new_password) < 6) {
            $return['message'] = 'Please enter a new password of at least 6 characters';
        } else {
            // Decode token first
            $token = $this->base64url_decode($encoded_token);

            // Find user by decoded token
            $user = $this->Api_model->getRecordByColumn('token', $token, 'users', 'id');

            if (!$user) {
                $return['message'] = 'Invalid token or user not found';
            } else {
                // Match register password hashing (md5)
                $hashed_password = md5($new_password);

                $update = array(
                    'password' => $hashed_password
                    // Optionally clear token: 'token' => ''
                );

                $this->Api_model->updateTable('id', $user[0]['id'], 'users', $update);

                $return['status'] = 'done';
                $return['message'] = 'Password has been reset successfully';
            }
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }

    /** user login  **/
    
  public function loginUser_post() {
    $return = array('status'=>'error','message'=>'Please send all required parameters','result'=>'');
    $input = $this->input->post();

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $phone = removeAllSpecialCharcter($data['phone']);
    $password = $data['password'];
    $inkPassword = md5($password);

    if ($phone == '') {
        $return['message'] = 'Phone number is required';
    } elseif (!is_numeric($phone) || strlen($phone) != 10) {
        $return['message'] = 'Phone number is not valid';
    } else {
        $checkUser = $this->Api_model->getRecordByColumn('mobile', $phone, 'users', 'id,name,mobile,email,token,varified_user,password');
        if ($checkUser === FALSE) {
            $return['message'] = 'This phone number does not exist.';
            $return['result'] = $phone;
        } elseif ($checkUser[0]['varified_user'] == 'No') {
            $return['message'] = 'Your number is not verified by the admin';
        } elseif ($checkUser[0]['password'] !== $inkPassword) {
            $return['message'] = 'Wrong Password';
        } else {
            // Generate token if not exists
            if ($checkUser[0]['token'] == '') {
                $auth = md5(date('Ymdhis') . rand(10, 9999));
                $updateInfo = array('token' => $auth);
                $this->Api_model->updateTable('id', $checkUser[0]['id'], 'users', $updateInfo);
            } else {
                $auth = $checkUser[0]['token'];
            }

            // Successful login response
            $return = array(
                'status' => 'done',
                'message' => 'User login successfully.',
                'token' => $auth,
                'userid' => $checkUser[0]['id'],
                'name' => $checkUser[0]['name'],
                'email' => $checkUser[0]['email'],
                'phone' => $checkUser[0]['mobile']
            );
        }
    }

    $this->response($return, REST_Controller::HTTP_OK);
}

    
public function userProfile_post() {
        $return = array('status'=>'error','message'=>'Please send all required parameters','result'=>'');
         
        $json = file_get_contents('php://input');
	    $data = json_decode($json,true);
        $token = removeAllSpecialCharcter($data['token']);
        
        if($token=='') {
            $return['message'] = 'Please pass the valid token.';
        }
        else {
            $userData = $this->Api_model->getRecordByColumn('token',$token,'users','id,name,email,mobile,varified_user');
            
            if($userData){
                $return['status'] = 'done';
                $return['message'] = 'Done.';
                $return['result'] = $userData;
            }
            else{
                $return['message'] = 'No Records Found';    
            }
            }
        
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function forgetPassword_post() {
        $return = array('status' => 'error', 'message' => 'Please send all required parameters', 'result' => '');

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $email = isset($data['email']) ? $data['email'] : '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) < 10) {
            $return['message'] = 'Email is not valid';
        } else {
            // Check if email exists
            $checkEmail = $this->Api_model->getRecordByColumn('email', $email, 'users', 'id,email,token');

            if (!$checkEmail) {
                $return['message'] = 'We can\'t find your email address';
            } else {
                // Generate new token and update user record
                $newToken = md5(uniqid(rand(), true));
                $this->Api_model->updateTable('id', $checkEmail[0]['id'], 'users', ['token' => $newToken]);

                // Encode token for URL
                $qstring = $this->base64url_encode($newToken);
                $url = 'https://bestpropertiesmohali.com/resetPassword/' . $qstring;
                $link = '<a href="' . $url . '">' . $url . '</a>';

                // Prepare email
                $to = $email;
                $subject = "Best Properties Forgot Password";
                $message = '<strong>Please click here to reset the password:</strong> ' . $link;
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                $headers .= "From: Best Properties <info@bestproperties.com>\r\n";

                if (mail($to, $subject, $message, $headers)) {
                    $return['status'] = 'done';
                    $return['message'] = 'A password reset has been requested for this email account';
                    $return['result'] = 'done';
                } else {
                    $return['message'] = 'Failed to send reset email';
                }
            }
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }
	
	public function base64url_encode($data) { 
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    } 

    public function base64url_decode($data) { 
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    }


    public function addToWishlist_post() {
        $return = array('status'=>'error','message'=>'Required parameters missing','result'=>'');

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $userId = isset($data['userid']) ? (int)$data['userid'] : 0;
        $propertyId = isset($data['property_id']) ? trim($data['property_id']) : '';

        if ($userId == 0 || $propertyId == '') {
            $return['message'] = 'User ID or Property ID is missing.';
        } else {
            $userData = $this->Api_model->getRecordByColumn('id', $userId, 'users', 'wishlisted_properties_id');

            if (!$userData) {
                $return['message'] = 'User not found.';
            } else {
                $currentList = $userData[0]['wishlisted_properties_id'];
                $propertyArray = array_filter(explode(',', $currentList));
                if (!in_array($propertyId, $propertyArray)) {
                    $propertyArray[] = $propertyId;
                }
                $newList = implode(',', $propertyArray);
                $this->Api_model->updateTable('id', $userId, 'users', ['wishlisted_properties_id' => $newList]);

                $return['status'] = 'done';
                $return['message'] = 'Property added to wishlist.';
                $return['result'] = $newList;
            }
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function removeFromWishlist_delete() {
            $return = array('status'=>'error','message'=>'Required parameters missing','result'=>'');

            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $userId = isset($data['userid']) ? (int)$data['userid'] : 0;
            $propertyId = isset($data['property_id']) ? trim($data['property_id']) : '';

            if ($userId == 0 || $propertyId == '') {
                $return['message'] = 'User ID or Property ID is missing.';
            } else {
                $userData = $this->Api_model->getRecordByColumn('id', $userId, 'users', 'wishlisted_properties_id');

                if (!$userData) {
                    $return['message'] = 'User not found.';
                } else {
                    $propertyArray = array_filter(explode(',', $userData[0]['wishlisted_properties_id']));
                    $propertyArray = array_diff($propertyArray, [$propertyId]);
                    $newList = implode(',', $propertyArray);

                    $this->Api_model->updateTable('id', $userId, 'users', ['wishlisted_properties_id' => $newList]);

                    $return['status'] = 'done';
                    $return['message'] = 'Property removed from wishlist.';
                    $return['result'] = $newList;
                }
            }

            $this->response($return, REST_Controller::HTTP_OK);
        }

    public function getWishlist_get() {
        $userId = $this->input->get('userid');
        $return = array('status' => 'error', 'message' => 'User ID is missing', 'result' => '');

        if (!$userId || !is_numeric($userId)) {
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $userData = $this->Api_model->getRecordByColumn('id', $userId, 'users', 'wishlisted_properties_id');

        if (!$userData || empty($userData)) {
            $return['message'] = 'User not found.';
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $wishlistRaw = $userData[0]['wishlisted_properties_id'] ?? null;

        if (is_null($wishlistRaw) || trim($wishlistRaw) === '') {
            $return['message'] = 'No wishlist found for this user.';
            $this->response($return, REST_Controller::HTTP_OK);
        }

        $rawIds = explode(',', trim($wishlistRaw, ', '));
        $wishlistIds = [];

        foreach ($rawIds as $id) {
            $id = intval(trim($id));
            if ($id > 0) {
                $wishlistIds[] = $id;
            }
        }

        if (empty($wishlistIds)) {
            $return['message'] = 'Wishlist is empty or invalid.';
            $this->response($return, REST_Controller::HTTP_OK);
        }

        try {
            $this->db->where_in('id', $wishlistIds);
            $query = $this->db->get('properties');
            $properties = $query->result_array();

            $finalResult = [];

            foreach ($properties as $property) {
                $city = $property['city'] ?? 'MO';
                $clone_id = $property['clone_id'] ?? null;

                $main_site = null;

                if ($clone_id) {
                    $cloneQuery = $this->db
                        ->select('main_site')
                        ->from('properties_clone')
                        ->where('id', $clone_id)
                        ->get();
                    $cloneData = $cloneQuery->row_array();
                    $main_site = $cloneData['main_site'] ?? '';
                }

                $cityPrefix = substr(preg_replace('/\s+/', '', strtolower($city)), 0, 2);
                $sitePrefix = substr(preg_replace('/\s+/', '', strtolower($main_site ?? 'BP')), 0, 2);
                $unique_id = strtoupper($cityPrefix . $sitePrefix . $property['id']);

                $property['unique_id'] = $unique_id;
                $finalResult[] = $property;
            }

            if (!empty($finalResult)) {
                $return['status'] = 'done';
                $return['message'] = 'Wishlist properties fetched successfully.';
                $return['result'] = $finalResult;
            } else {
                $return['message'] = 'No matching properties found.';
            }

        } catch (Exception $e) {
            $return['message'] = 'No wishlist properties added yet.';
        }

        $this->response($return, REST_Controller::HTTP_OK);
    }

public function getWishlist_ids_get() {
    $userId = $this->input->get('userid');
    $return = array('status' => 'error', 'message' => 'User ID is missing', 'result' => '');

    if (!$userId || !is_numeric($userId)) {
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // Fetch user data
    $userData = $this->Api_model->getRecordByColumn('id', $userId, 'users', 'wishlisted_properties_id');

    if (!$userData || empty($userData)) {
        $return['message'] = 'User not found.';
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    $wishlistRaw = $userData[0]['wishlisted_properties_id'] ?? null;

    if (is_null($wishlistRaw) || trim($wishlistRaw) === '') {
        $return['message'] = 'No wishlist found for this user.';
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // Process raw comma-separated IDs
    $rawIds = explode(',', trim($wishlistRaw, ', '));
    $wishlistIds = [];

    foreach ($rawIds as $id) {
        $id = intval(trim($id));
        if ($id > 0) {
            $wishlistIds[] = $id;
        }
    }

    if (empty($wishlistIds)) {
        $return['message'] = 'Wishlist is empty or invalid.';
        return $this->response($return, REST_Controller::HTTP_OK);
    }

    // Success response
    $return['status'] = 'done';
    $return['message'] = 'Wishlist property IDs fetched successfully.';
    $return['result'] = $wishlistIds;

    return $this->response($return, REST_Controller::HTTP_OK);
}

public function adminlogin_post()
{
    $email = $this->post('email');
    $password = $this->post('password');

    if (empty($email) || empty($password)) {
        $this->response([
            'status' => false,
            'message' => 'Email and password are required.'
        ], REST_Controller::HTTP_BAD_REQUEST);
        return;
    }

    // Get user data by email
    $user = $this->Api_model->getRecordByColumn('email', $email, 'adminLogin');

    if ($user) {
        $storedHash = $user[0]['password'];
        $inputPassword = trim($password);
        $hashedInput = hash_hmac("sha512", $inputPassword, $this->salt);
        
        if ($hashedInput === $storedHash) {
            // Check for token
            $token = $user[0]['token'];
            if (empty($token)) {
                $rawToken = date('YmdHis') . rand(1000, 9999);
                $token = hash_hmac("sha256", $rawToken, $this->salt);
                $this->Api_model->updateTable('id', $user[0]['id'], 'adminLogin', ['token' => $token]);
                $user[0]['token'] = $token; // update locally for response
            }

            unset($user[0]['password']); 

            $this->response([
                'status' => true,
                'message' => 'Login successful.',
                'data' => $user[0]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Invalid password.'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    } else {
        $this->response([
            'status' => false,
            'message' => 'Invalid email.'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }
}





}