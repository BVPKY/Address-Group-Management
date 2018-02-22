<?php


class Database{
    
    /* 
	 * Create variables for credentials to MySQL database
	 * The variables have been declared as private. This
	 * means that they will only be available with the 
	 * Database class
	 */
    private $db_host = "localhost";  // Server address
    private $db_user = "root";  // database User name
    private $db_pass = "";  // database user password
    private $db_name = "inmar"; // database name
    
    /*
	 * Extra variables that are required by other function such as boolean con variable
	 */
    protected $connection = false; // Check to see if the connection is active
    protected $myconn = ""; // This will be our mysqli object

    /**
     * Access Modifier of the database class should be protected
     * because we are making it a super class for the readable and writable database classes
     * only they should access this constructor.
     */
    protected function __construct($db_user, $db_pass, $db_name) {
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }

    public function getServerName() {
        return $this->db_host;
    }
    
    public function getDBUserName() {
        return $this->db_user;
    }

    /**
     * Returns the database name
     * @return string
     */
    public function getDBName() {
        return $this->db_name;
    }

    /**
     * Connect to the database
     * @return boolean
     */
    public function connect(){
	if(!$this->connection){
            try {
                // create 
                $this->myconn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);  // mysql_connect() with variables defined at the start of Database class
                if($this->myconn->connect_errno > 0){
                    array_push($this->result, $this->myconn->connect_error);
                    return false; // Problem selecting database return FALSE
                } else {
                    $this->connection = true;
                    return true; // Connection has been made, return TRUE
                }
            } catch (Exception $ex) {
                echo $ex;
                return false;
            }
            
        }else{
            return true; // Connection has already been made, return TRUE 
        }
    }
    
    /**
     * Disconnect from the database
     * @return boolean
     */
    public function disconnect(){
    	// If there is a connection to the database
    	if($this->connection){
            // We have found a connection, try to close it
            if($this->myconn->close()){
    		// We have successfully closed the connection, set the connection variable to false
    		$this->connection = false;
		// Return true tjat we have closed the connection
                return true;
            }else{
		// We could not close the connection, return false
		return false;
            }
	}
    }
    
    // Private function to check if table exists for use with queries
    protected function tableExists($table) {
    	$tablesInDb = $this->myconn->query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb){
            if($tablesInDb->num_rows == 1){
                return true; // The table exists
            }else{
                array_push($this->result,$table." does not exist in this database");
                return false; // The table does not exist
            }
        }
    }

    // Escape your string
    public function escapeString($data){
        return $this->myconn->real_escape_string($data);
    }
}