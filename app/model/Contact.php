<?php


class Contact {
    //put your code here
    protected $userid; // unique id of the user

    protected $name; // name
    
    protected $gender; // gender of the user
    protected $address = array(); // address of the user
    
    protected $mobile; // mobile no. of the user
    protected $email; // email of the user
    
    function __construct($contactof, $name, $gender, $mobile, $email, $address = array()) {
        $this->userid = $contactof;
        $this->name = $name;
        $this->gender = $gender;
        $this->address = $address;
        $this->mobile = $mobile;
        $this->email = $email;
    }
    
    public function __get($name) {
        // this method returns the value of the attribute that is passed
        // through $name
        
        return $this->$name;
    }
    
    public function __set($name, $value ) {
        
        // first check whether the given name is valid attribute or not
        // for that we are gonna use a switch statement
        switch($name) {
            
            case "userid" :
                $this -> userid = $value;
                break;
            
            case "name" :
                $this -> name = $value;
                break;
            
            case "gender" :
                $this -> gender = $value;
                break;
            
            case "address" : 
                $this -> address = $value;
                break;
            
            case "mobile_no" :
                $this->mobile = $value;
                break;
              
            case "email" :
                $this -> email = $value;
                break;
             
            default : return "Invalid"; // when the passes attribute doesnt exist
        }
        
    }

}
