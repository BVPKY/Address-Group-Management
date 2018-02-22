<?php
class User {
    // Lets create the attributes of a person in protected accesss
    
    // this static variable will keep track of whether or not the Person object is modified
    public $isModified = false;
    
    protected $userid; // unique id of the user

    protected $first_name; // first name
    protected $sur_name; // sur name
    
    protected $gender; // gender of the user
    protected $address = array(); // address of the user
    
    protected $mobile_no; // mobile no. of the user
    protected $email_id; // email of the user
    protected $UID; // Aadhar Number of the user
    
    private $login_credentials;

    // this constructor will initialize all the attributes of the Person.
    function __construct($userid, $f_name, $sur_name, $email_id, $gender, $mobile_no, $UID, $credentials, $address = []) {
        
        $this-> first_name  = $f_name;
        $this-> sur_name    = $sur_name;
        $this-> gender      = $gender;
        $this-> address     = $address;
        $this-> mobile_no   = $mobile_no;
        $this-> UID         = $UID;
        
        $this->email_id = $email_id;
        $this->login_credentials = $credentials;
        $this->userid = $userid;
    }
    
    /**
     * Get method on Person that returns the attribute's value, with which we called it
     * @param type $name
     * @return type
     */
    public function __get($name) {
        // this method returns the value of the attribute that is passed
        // through $name
        
        return $this->$name;
    }
    
    /**
     * Sets the value of an attribute
     * @param type $name
     * @param type $value
     * @return string
     */
    public function __set($name, $value ) {
        
        // first check whether the given name is valid attribute or not
        // for that we are gonna use a switch statement
        switch($name) {
            
            case "first_name" :
                $this -> first_name = $value;
                break;
            
            case "sur_name" :
                $this -> sur_name = $value;
                break;
            
            case "gender" :
                $this -> gender = $value;
                break;
            
            case "address" : 
                $this -> address = $value;
                break;
            
            case "mobile_no" :
                $this->mobile_no = $value;
                break;
            
            case "UID" :
                $this -> UID = $value;
                break;
                
            case "email_id" :
                $this -> email_id = $value;
                break;
             
            default : return "Invalid"; // when the passes attribute doesnt exist
        }
        
    }
    
}
