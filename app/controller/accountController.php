<?php

class accountController extends Controller{
    //put your code here
    
    /**
     * This method will Redirect to login page
     */
    public function index() {
        Session::start();
        if(Session::isActive()) {
            echo "<script>window.location('/user/index');</script>";
        } else {
            echo "<script>window.location('/account/login');</script>";
        }
    }
    
    /**
     * When the user goes to login page this 
     * method will be called. So this can be 
     * considered as the index page for the account
     * controller
     *
     */
    public function login() {

        Session::start();
        if(Session::isActive()) {
            echo "<script>window.location('/user/index');</script>";
        } else {
            $this->view('account'. DIRECTORY_SEPARATOR .'login');

            // first read the username and password that the user entered
            $uname = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
            $pword = filter_input(INPUT_POST, 'pword', FILTER_SANITIZE_STRING);
            
            $btn = filter_input(INPUT_POST, 'btnSubmit', FILTER_SANITIZE_STRING);

            if(isset($uname) && isset($pword) && isset($btn)) {
                $this->user_login_input($uname, $pword);
            }
            $this->view->render();
        }
    }
    
    public function logout() {
        Session::start();


        if(Session::isActive()) {
            Session::destroy();
            echo "<script>alert('Successfully Logged out')</script>";
            echo "<script>window.location('/account/login');</script>";
        } else {
            Session::destroy();
            echo "<script>alert('No body has logged in here')</script>";
            echo "<script>window.location('/account/login');</script>";
        }
    }

    public function signup() {
        Session::start();
        if(Session::isActive()) {
            echo "<script>window.location('/user/index');</script>";
        } else {
            $this->view('account'. DIRECTORY_SEPARATOR .'signup');

            // first read the username and password that the user entered
            $fname = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
            $sname = filter_input(INPUT_POST, 'surName', FILTER_SANITIZE_STRING);
            $aadhar = filter_input(INPUT_POST, 'aadhar', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_STRING);
            $pword = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
            $line_1 = filter_input(INPUT_POST, 'line_1', FILTER_SANITIZE_STRING);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
            $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
            $zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING);
            $btn = filter_input(INPUT_POST, 'btnSignup', FILTER_SANITIZE_STRING);

            $credentials = new LoginCredentials($email, $pword);
            $user = new User(null, $fname, $sname, $email, $gender, $mobile, $aadhar, $credentials, [
                'line_1' => $line_1,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'zipcode' => $zipcode
            ]);
            
            if(isset($btn)) {
                $db = WritableDatabase::getWritableDatabase();
                $result = $db->createUser($user);
                
                if($result == true ) {
                    echo "<script>alert('User Created. Please Login');</script>";
                    echo "<script>window.location('/account/login');</script>";
                } else {
                    echo "<script>alert('Could not create user');</script>";
                    echo "<script>window.location('/account/signup');</script>";
                }
            }
            $this->view->render();
        }
    }
    
    /**
     * This method will validate a user credentials 
     * and if he is a valid user it will take him to  his
     * account
     *
     * @param type $uname
     * @param type $pword
     * @return type
     */
    private function user_login_input($uname, $pword) {

        if(isset($uname) && isset($pword)) { // if password and username are set

            if(file_exists(MODEL . 'LoginCredentials.php')) {
                
                //require MODEL . 'LoginCredentials.php';
                $loginCred = new LoginCredentials($uname, $pword);

                $db = ReadableDatabase::getReadableDatabase();
                $uid = $db->getAccount($loginCred);
                
                if($uid == null) {
                    //echo "<script>window.location('/account/login');</script>";
                    echo 'Invalid Credentials Entered!!!';
                    return;
                }
                
                // now lets read the details of the user from the database
                // getUser method will return a staff object or one of its derived classes
                $user = $db->getUser($uid, $loginCred);
                
                Session::start();
                Session::set('user', $user);
                echo "<script>window.location('/user/index');</script>";
            }
        } else {
            echo "<script>window.location('/account/login');</script>";
            echo 'Enter details correctly';
        }
    }
    
}
/*
INSERT INTO address_table(`line_1`, `city`, `state`, 		`country`, `zipcode`) 
	VALUES(addr_1, city, state, country, zip);
    
SET temp_data = SELECT ad.address_id INTO temp_id FROM address_table ad ORDER BY ad.address_id DESC LIMIT 1;

INSER INTO contacts(`email`, `name`, `contact_of`, `mobile`, `gender`, `address_id`) 
	VALUES(email, name, uid, mobile, gender, );
 * 
 *  */

