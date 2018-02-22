<?php

class WritableDatabase extends Database{
    //put your code here
    protected function __construct($db_user, $db_pass, $db_name) {
        parent::__construct($db_user, $db_pass, $db_name);
    }

    public static function getWritableDatabase() {
        static $instance = null;
        
        if($instance == null) {
            $instance = new WritableDatabase("root", "", "inmar");
        }
        return $instance;
    }
    
    public function createUser($user) {
        $this->connect(); // open the conection
        mysqli_autocommit($this->myconn,FALSE); // disable auto commit
        
        $res = $this->myconn->query("INSERT INTO address_table(line_1, city, state, country, zipcode)"
                . " VALUES('{$user->address['line_1']}','{$user->address['city']}','{$user->address['state']}','{$user->address['country']}','{$user->address['zipcode']}');");
        
        if($res) { // if address is created successfully, then
            
            // read the newly created address's id from the address table
            $res = $this->myconn->query("SELECT address_id FROM address_table ORDER BY address_id DESC LIMIT 1");
            $row = $res->fetch_array();
            $address_id = $row['address_id'];
            
            // read the last created user's id from user table
            $res = $this->myconn->query("SELECT user_id FROM user ORDER BY user_id DESC LIMIT 1");
            $row = $res->fetch_array();
            $olduser_id = $row['user_id'];
            
            $matches = [];
            preg_match("/(\d+)(.)/", $olduser_id, $matches); // regular expression to match the number in the user name Ex: U320 => matchs 320
            $number = $matches[0]; // Number will be in 0th location
            
            $number++;
            $user_id = 'U'.$number; // create a new user id for the new user
            
            // enter the data into the user table
            $this->myQuery = "INSERT INTO user(user_id, email_id, name, surname, gender, mobile, UID, address_id)"
                            . " VALUES('{$user_id}', '{$user->email_id}', '{$user->first_name}', '{$user->sur_name}', "
                            . "'{$user->gender}', '{$user->mobile_no}', '{$user->UID}', {$address_id});";

            $queryResult1 = $this->myconn->query($this->myQuery); // run the query

            // enter the login credentials into the login table
            $queryResult2 = $this->myconn->query("INSERT INTO login(username, password, user_id)"
                            . " VALUES('{$user->email_id}', '{$user->login_credentials->password}', '{$user_id}');");
            
            if($queryResult1 && $queryResult2) { // if data successfully entered
                mysqli_commit($this->myconn);
                $this->disconnect();
                return true;
            } else { // data is not successfully entered
                mysqli_rollback($this->myconn);
                $this->disconnect();
                return false;
            }
        }else {
            mysqli_rollback($this->myconn);
            $this->disconnect();
            return false;
        }
    }
    
    public function createContact($contact) {
        $this->connect(); // open the conection
        
        $res = $this->myconn->query("INSERT INTO address_table(line_1, city, state, country, zipcode)"
                . " VALUES('{$contact->address['line_1']}','{$contact->address['city']}','{$contact->address['state']}','{$contact->address['country']}','{$contact->address['zipcode']}');");
        
        if($res) {
            $res = $this->myconn->query("SELECT address_id FROM address_table ORDER BY address_id DESC LIMIT 1");
            $row = $res->fetch_array();
            $address_id = $row['address_id'];

            $this->myQuery = "INSERT INTO contacts(name, email, contact_of, mobile, address_id, gender, status)"
                            . " VALUES('{$contact->name}', '{$contact->email}', '{$contact->userid}', '{$contact->mobile}', "
                            . " '{$address_id}', '{$contact->gender}', 'active' );";

            $queryResult = $this->myconn->query($this->myQuery);

            //echo $this->myQuery;
            
            $this->disconnect();
            if($queryResult) {
                return true;
            } else {
                return false;
            }
        }else {
            $this->disconnect();
            return false;
        }
    }
    
    public function createGroup($group) {
        $this->connect(); // open the conection
        mysqli_autocommit($this->myconn,FALSE);
            
        $this->myQuery = "INSERT INTO contact_group(gname, admin)"
                        . " VALUES('{$group->groupname}', '{$group->admin}');";
                        
        $queryResult = $this->myconn->query($this->myQuery);

        if($queryResult) { // if data entered successfully
            mysqli_commit($this->myconn); // commit the transaction
            $this->disconnect(); // disconnect from the database
            return true; // return true as a mark of success
        } else { // if query run failed
            mysqli_rollback($this->myconn); // roll back the transaction
            $this->disconnect(); // disconnect
            return false; // return false as a mark of failure
        }
    }
    
    public function deleteContact($contact_id, $user_id) {
        $this->connect(); // open the conection
        mysqli_autocommit($this->myconn,FALSE);
            
        $this->myQuery = "DELETE FROM contactS WHERE contacts.contact_id = {$contact_id} AND contacts.contact_of = '{$user_id}';";
                        
        $queryResult = $this->myconn->query($this->myQuery);

        if($queryResult) { // if data deleted successfully
            mysqli_commit($this->myconn); // commit the transaction
            $this->disconnect(); // disconnect from the database
            return true; // return true as a mark of success
        } else { // if query run failed
            mysqli_rollback($this->myconn); // roll back the transaction
            $this->disconnect(); // disconnect
            return false; // return false as a mark of failure
        }
    }
    
    public function deleteGroup($group_id, $user_id) {
        $this->connect(); // open the conection
        mysqli_autocommit($this->myconn,FALSE);

        $this->myQuery = "DELETE FROM contact_group WHERE contact_group.group_id = {$group_id} AND contact_group.admin = '{$user_id}';";

        $queryResult = $this->myconn->query($this->myQuery);

        if($queryResult) { // if data deleted successfully
            mysqli_commit($this->myconn); // commit the transaction
            $this->disconnect(); // disconnect from the database
            return true; // return true as a mark of success
        } else { // if query run failed
            mysqli_rollback($this->myconn); // roll back the transaction
            $this->disconnect(); // disconnect
            return false; // return false as a mark of failure
        }
    }
    
    public function makeContactActivePassive($user_id, $contactid, $status) {
        $this->connect(); // open the conection
        mysqli_autocommit($this->myconn,FALSE);

        $this->myQuery = "UPDATE contacts SET contacts.status = '{$status}' WHERE contacts.contact_of = '{$user_id}' AND contacts.contact_id = {$contactid};";

        $queryResult = $this->myconn->query($this->myQuery);

        echo mysqli_error($this->myconn);
        
        if($queryResult) { // if data deleted successfully
            mysqli_commit($this->myconn); // commit the transaction
            $this->disconnect(); // disconnect from the database
            return true; // return true as a mark of success
        } else { // if query run failed
            mysqli_rollback($this->myconn); // roll back the transaction
            $this->disconnect(); // disconnect
            return false; // return false as a mark of failure
        }
    }
}
