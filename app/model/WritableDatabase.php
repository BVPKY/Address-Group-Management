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

        // prepare the procedure GET_USER(userid) to get the details of the user
        
        $res = $this->myconn->query("INSERT INTO address_table(line_1, city, state, country, zipcode)"
                . " VALUES('{$user->address['line_1']}','{$user->address['city']}','{$user->address['state']}','{$user->address['country']}','{$user->address['zipcode']}');");
        
        if($res) {
            $res = $this->myconn->query("SELECT address_id FROM address_table ORDER BY address_id DESC LIMIT 1");
            $row = $res->fetch_array();
            $address_id = $row['address_id'];
            
            $res = $this->myconn->query("SELECT user_id FROM user ORDER BY user_id DESC LIMIT 1");
            $row = $res->fetch_array();
            $olduser_id = $row['user_id'];
            
            preg_match("/(\d+)(.)/", $olduser_id, $matches);

            $number = $matches[0];
            
            $number++;
            $user_id = 'U'.$number;
            
            $this->myQuery = "INSERT INTO user(user_id, email_id, name, surname, gender, mobile, UID, address_id)"
                            . " VALUES('{$user_id}', '{$user->email_id}', '{$user->first_name}', '{$user->sur_name}', "
                            . "'{$user->gender}', '{$user->mobile_no}', '{$user->UID}', {$address_id});";


            $queryResult1 = $this->myconn->query($this->myQuery);
                         
            echo $this->myQuery;
            
            $queryResult2 = $this->myconn->query("INSERT INTO login(username, password, user_id)"
                            . " VALUES('{$user->email_id}', '{$user->login_credentials->password}', {$user_id}');");
            
            $this->disconnect();
            if($queryResult1 && $queryResult2) {
                return true;
            } else {
                return false;
            }
        }else {
            $this->disconnect();
            return false;
        }
    }
    
    
}
