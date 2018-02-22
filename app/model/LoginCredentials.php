<?php
class LoginCredentials {
    // This class will hold the user name and password of a staff member
    // When a person tries to signin, the uname and pword he gives,
    // will be taken and we create an object of the LoginCredentials and 
    // pass this object to the Database classes to retrieve the details of
    // the staff person whose details match with this uname and pword;
    
    private $username;
    private $password;
    
    public function __construct($uname, $pword) {
        
        $this->username = $uname;
        $this->password = $this->encryptPassword($pword);
        
        //echo "Object created for your credentials ". $this->username ."and encrypted password is ". $this->password;
        
    }
    
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
            
            case "username" :
                $this -> first_name = $value;
                break;
            default : return "Invalid"; // when the passes attribute doesnt exist
        }
    }
    
    private function encryptPassword($password) {
        // write the encryption logic here in the future edits
        
        
        return $password;
    }
    
}
