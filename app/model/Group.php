<?php

class Group {
    //put your code here
    protected $groupname; // name of the group
    protected $groupid; // id of the group
    
    protected $admin; // admin of the group
    
    function __construct($groupname, $groupid, $admin) {
        $this->groupname = $groupname;
        $this->groupid = $groupid;
        $this->admin = $admin;
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
            
            case "groupname" :
                $this -> groupname = $value;
                break;
            
            case "groupid" :
                $this -> groupid = $value;
                break;
            
            case "admin" :
                $this -> admin = $value;
                break;
            
            default : return "Invalid"; // when the passes attribute doesnt exist
        }
        
    }


}
