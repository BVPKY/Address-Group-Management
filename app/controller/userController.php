<?php


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
            $contact = $_REQUEST['arr'];
            print_r($contact);
            
            if(isset($btn)) {
                $db = ReadableDatabase::getReadableDatabase();
                $res = $db->createContact($contact);
                if($res) {
                    echo "<script>alert('Contact Created');</script>";
                    echo "<script>window.location('/view_contacts');</script>";
                } else {
                    echo "<script>alert('Contact Not Created');</script>";
                    echo "<script>window.location('/index');</script>";
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
            $group_name = filter_input(INPUT_POST, 'group_name', FILTER_SANITIZE_STRING);
            
            if(isset($btn) && isset($group_name)) {
                $db = ReadableDatabase::getReadableDatabase();
                $res = $db->createGroup($group_name);
                if($res) {
                    echo "<script>alert('Contact Created');</script>";
                    echo "<script>window.location('/view_contacts');</script>";
                } else {
                    echo "<script>alert('Contact Not Created');</script>";
                    echo "<script>window.location('/index');</script>";
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
            
            $this->view->addViewData('contacts', $contacts);
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
            
            $this->view->addViewData('groups', $groups);
            $this->view->render();
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
}