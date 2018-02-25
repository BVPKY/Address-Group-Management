<?php

/**
 * Description of userController
 *
 */
class userController extends Controller{
    //put your code here
   
    public function index() {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'index',['user' => $user]);
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function create_contact() {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'create_contact',['user' => $user]);
            
            $btn = filter_input(INPUT_POST, 'btnCreate', FILTER_SANITIZE_STRING);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_STRING);
            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
            $line_1 = filter_input(INPUT_POST, 'line_1', FILTER_SANITIZE_STRING);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
            $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
            $zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING);
            
            $contact = new Contact($user->userid, $name, $gender, $mobile, $email, [
                'line_1' => $line_1,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'zipcode' => $zipcode
            ]);
            
            if(isset($btn)) {
                $db = WritableDatabase::getWritableDatabase();
                $res = $db->createContact($contact);
                if($res) {
                    echo "<script>alert('Contact Created');</script>";
                    echo "<script>window.location('view_contacts');</script>";
                } else {
                    echo "<script>alert('Contact Not Created');</script>";
                    echo "<script>window.location('index');</script>";
                }
            }
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function create_group() {
        Session::start();
        if(Session::isActive()) {
            
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'create_group',['user' => $user]);
            
            $btn = filter_input(INPUT_POST, 'btnCreate', FILTER_SANITIZE_STRING);
            $name = filter_input(INPUT_POST, 'groupname', FILTER_SANITIZE_STRING);
            
            $group = new Group($name, null, $user->userid);
                        
            if(isset($btn)) {
                $db = WritableDatabase::getWritableDatabase();
                $res = $db->createGroup($group);
                
                if($res) {
                    echo "<script>alert('Group Created');</script>";
                    echo "<script>window.location('view_groups');</script>";
                } else {
                    echo "<script>alert('Group Not Created');</script>";
                    echo "<script>window.location('index');</script>";
                }
                
            }
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function view_contacts() {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'view_contacts',['user' => $user]);
            
            $db = ReadableDatabase::getReadableDatabase();
            $contacts = $db->getUserContacts($user->userid);
            
            if($contacts) {
                $this->view->addViewData('contacts', $contacts);
            }
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function view_groups() {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'view_groups',['user' => $user]);
            
            $db = ReadableDatabase::getReadableDatabase();
            $groups = $db->getUserGroups($user->userid);
            
            if($groups) {
                $this->view->addViewData('groups', $groups);
            }
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function delete_group($group_id = null) {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'delete_group',['user' => $user]);
            
            if($group_id == null) {
                $btn = filter_input(INPUT_POST, 'btnDelete', FILTER_SANITIZE_STRING);
                $group_id = filter_input(INPUT_POST, 'groupid', FILTER_SANITIZE_STRING);
                if (!(isset($group_id) || isset($btn))) {
                    $this->view->render();
                }
            }
            
            if($group_id != null) {
                $db = WritableDatabase::getWritableDatabase();
                $res = $db->deleteGroup($group_id, $user->userid);

                if($res) {
                    echo "<script>alert('Group Deleted');</script>";
                    echo "<script>window.location('/user/view_groups');</script>";
                } else {
                    echo "<script>alert('Group Not Deleted');</script>";
                    echo "<script>window.location('/user/view_groups');</script>";
                }
            }
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function delete_contact($contact_id = null) {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'delete_contact',['user' => $user]);
            
            if($contact_id == null) {
                $btn = filter_input(INPUT_POST, 'btnDelete', FILTER_SANITIZE_STRING);
                $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_SANITIZE_STRING);
                if (!(isset($contact_id) || isset($btn))) {
                    $this->view->render();
                }
            }
            
            if($contact_id != null) {
                $db = WritableDatabase::getWritableDatabase();
                $res = $db->deleteContact($contact_id, $user->userid);

                if($res) {
                    echo "<script>alert('Contact Deleted');</script>";
                    echo "<script>window.location('/user/view_groups');</script>";
                } else {
                    echo "<script>alert('Contact Not Deleted');</script>";
                    echo "<script>window.location('/user/view_groups');</script>";
                }
            }
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function add_contact_to_group() {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'add_contact_to_group',['user' => $user]);
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function make_contact_active($contact_id) {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'view_contacts',['user' => $user]);
            
            $db = WritableDatabase::getWritableDatabase();
            
            $status = 'active';
            $res = $db->makeContactActivePassive($user->userid, $contact_id, $status);
            
            if($res) {
                    echo "<script>alert('Contact is Active now');</script>";
                    echo "<script>window.location('/user/view_contacts');</script>";
                } else {
                    echo "<script>alert('Could not make contact active');</script>";
                    echo "<script>window.location('/user/view_contacts');</script>";
                }
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function make_contact_passive($contact_id) {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'view_contacts',['user' => $user]);
            
            $db = WritableDatabase::getWritableDatabase();
            
            $status = 'passive';
            $res = $db->makeContactActivePassive($user->userid, $contact_id, $status);
            
            if($res) {
                    echo "<script>alert('Contact is Passive now');</script>";
                    echo "<script>window.location('/user/view_contacts');</script>";
                } else {
                    echo "<script>alert('Could not make contact passive');</script>";
                    echo "<script>window.location('/user/view_contacts');</script>";
                }
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
    
    public function search() {
        Session::start();
        if(Session::isActive()) {
            $user = Session::get('user');
            $this->accountView( 'user'. DIRECTORY_SEPARATOR . 'search',['user' => $user]);
            
            $db = ReadableDatabase::getReadableDatabase();
            $contacts = $db->getUserContacts($user->userid);
            
            if($contacts) {
                $this->view->addViewData('contacts', $contacts);
            }
            $this->view->render();
        } else {
            echo "<script>window.location('/account/login');</script>";
            return false;
        }
    }
}