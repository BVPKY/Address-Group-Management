<?php
/**
 * This database is a readable copy of the Database class
 * using this class we can only read the data from the database
 * this can help us seperate the write permissions from the read permissions
 * 
 */
class ReadableDatabase extends Database{
    //put your code here
    // 1. Login authentication
    
    protected function __construct($db_user, $db_pass, $db_name) {
        parent::__construct($db_user, $db_pass, $db_name);
    }

    public static function getReadableDatabase() {
        static $instance = null;
        
        if($instance == null) {
            $instance = new ReadableDatabase("root", "", "inmar");
        }
        return $instance;
    }
    
    /**
     * This method will take a LoginCredentials object and returns all the 
     * details of the user, if he/she found to be authentified
     * @param type $credentials
     */
    public function getAccount($credentials) {
        $this->connect();
        
        if(!$this->connection) {
            echo "<script>alert('Could Not Connect to database')</script>";
            return null;
        }
        
        // nullify the effect of escape sequences by putting \ before them
        $credentials->username =  $this->escapeString($credentials->username);
        
        $this->myQuery = "CALL check_user_exist( '{$credentials->username}', '{$credentials->password}');";        
        $queryResult = $this->myconn->query($this->myQuery);
                
        if($queryResult && mysqli_num_rows($queryResult) == 1) {
            // now we have the id of the user
            // lets take him to his account page
            // for that we first have to fetch his/her
            // user id which was returned by the sql query
            
            $row = $queryResult->fetch_array();
            $key = array_keys($row);            

            $userId = $row[$key[0]];

            // close the conection
            $this->disconnect();
            return $userId;
            
        } else {
            echo '<br>Failed<br>';
            $this->disconnect();
            return null;
        }
    }
    
    /**
     * This method takes two arguments one is user id and other is 
     * the login credentials(uname, pword) of the user
     * and returns an object representing himself(his details) read from the
     * database
     * 
     * @param String $userid
     * @param LoginCredentials $credentials
     * @return \Doctor
     */
    public function getUser($userid, $credentials) {
        $this->connect(); // open the conection

        // nullify the effect of escape sequences by putting \ before them
        $uid =  $this->escapeString($userid);
        
        // call the procedure GET_USER(userid) to get the details of the user
        $this->myQuery = "CALL GET_USER('{$uid}');";

        // run the query
        $queryResult = $this->myconn->query($this->myQuery);

        // if query result is success and number of rows are exactly one
        // then fetch the data
        if($queryResult && mysqli_num_rows($queryResult) == 1) {
            
            // read the details of the user and prepare a Object for him
            $row = $queryResult->fetch_array(); // get the row that was selected from the database

            // if the user is a doctor then create a doctor object
            $user = new User($uid, $row['name'], $row['surname'], $row['email_id'], $row['gender'],
                    $row['mobile'], $row['UID'], $credentials, $row['address']);
            
            $this->disconnect();
            return $user;
        } else {
            $this->disconnect();
            return null;
        }
        $this->disconnect();
    }
    
    public function getUserContacts($userid) {
        $this->connect(); // open the conection
        
        // call the procedure GET_USER(userid) to get the details of the user
        $this->myQuery = "CALL GET_USER_CONTACT('{$userid}');";

        // run the query
        $queryResult = $this->myconn->query($this->myQuery);
        
        //echo mysqli_error($this->myconn);
        
        // if query result is success and number of rows are exactly one
        // then fetch the data
        if($queryResult && mysqli_num_rows($queryResult) >= 1) {
            $this->disconnect();
            return $queryResult;
        } else {
            $this->disconnect();
            return null;
        }
    }
    public function getUserGroups($userid) {
        $this->connect(); // open the conection

        // call the procedure GET_USER(userid) to get the details of the user
        // call the procedure GET_USER(userid) to get the details of the user
        $this->myQuery = "CALL GET_USER_GROUPS('{$userid}');";

        // run the query
        $queryResult = $this->myconn->query($this->myQuery);

        $this->disconnect();
        
        // if query result is success and number of rows are exactly one
        // then fetch the data
        if($queryResult && mysqli_num_rows($queryResult) >= 1) {
            $this->disconnect();
            return $queryResult;
        } else {
            $this->disconnect();
            return null;
        }
    }
}