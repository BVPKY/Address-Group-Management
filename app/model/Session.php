<?php

class Session {
    //put your code here
    private static $sessionStarted = false;
    
    /**
     * @desc Starts a new Session, if it hasn't started
     * earlier
     */
    public static function start() {
        if(!self::$sessionStarted) {
            session_start();
            self::$sessionStarted = true;
        }
    }
    
    public static function isActive() {
        return self::$sessionStarted && isset($_SESSION['user']);
    }

    /**
     * @desc sets a session key, value pair
     * @param type $key
     * @param type $value
     */
    public static function set($key, $value) {
        echo 'setting';
        $_SESSION[$key] = $value;
        self::display();
    }
    
    /**
     * @desc Retrieves the value of a key, if it is set
     * @param type $key
     * @param type $secondKey
     * @return type
     */
    public static function get($key, $secondKey = false) {
        if($secondKey == true) {
            if(isset($_SESSION[$key][$secondKey])) {
                return $_SESSION[$key][$secondKey];
            }
        } else {
            if(isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
        }
    }
    
    /**
     * @desc prints the object in human readable form
     */
    public static function display() {
        echo '<pre>';
        print_r($_SESSION); 
        echo '</pre>';
    }
    
    /**
     * Finish the session without saving the changes in the 
     * ssession data. Thus, the original values in session data
     * are kept unchanged
     */
    public static function abort() {
        self::start();
        session_abort();
        //$this->sessionStarted = false;
    }
    
    /**
     * Clears the session data but session is still active
     * @param type $key
     */
    public static function unsetSession($key = false) {
        self::start();
        if ($key) {
            unset($_SESSION[$key]);
        } else {
            session_unset();
        }
        //$this->sessionStarted = false;
    }
    
    /**
     * Destroys the session. and kills all the session information
     */
    public static function destroy() {
        session_destroy();
        //$this->sessionStarted = false;
    }
}