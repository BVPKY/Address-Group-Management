<?php

class Application {
    //put your code here
    
    // this stores what controller we are using, by default it is home
    protected $controller = 'accountController';
    
    // this stores what page we are displaying
    protected $action = 'index';
    
   // this stores what parameters are being sent to this page, if any 
    protected $prams = [];
    
    /**
     * Constructor for the Application class
     */
    public function __construct() {
        
        require MODEL . 'ReadableDatabase.php';
        require MODEL . 'WritableDatabase.php';
        require MODEL . 'Session.php';
        require MODEL . 'LoginCredentials.php';
        require MODEL . 'User.php';
        
        // split the url and get the controller, action and parameters to the action
        $this->prepareURL();
        
        // now we have controller, action and parameters seperated and stored in
        // variables that represent them
        // first check whether he controller exist
        // if yes display it, else print error(or you can redirect to the home page)
        if(file_exists(CONTROLLER . $this->controller . '.php')) {
            // create an object for this contrlooer
            $this->controller = new $this->controller;
            
            if(method_exists($this->controller, $this->action)) {
                // if the controller class has the method in action variable
                // then call it 
                // not from here, but by using call_user_func_array
                call_user_func_array([$this->controller, $this->action], $this->prams);
            } else {
                // what if the method does not
            }
        } else {
            // the controller is not there
            echo 'Requested URL Can not be found :-(';
        }
    }
    
    /**
     * This method will split the URL into different
     * parts like, controller, action, and parameters
     */
    protected function prepareURL() {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        if( !empty($request)) {
            $url = explode('/', $request); // split the request into an array of controller, action, parameters
            
            // is controller is given, then set that name as controller
            // if this is empty, then make homeController as default controller
            $this->controller = isset($url[0]) ? $url[0].'Controller' : 'accountController';
            
            // action to be performed
            // it is specified after the controller name in the url
            // 
            $this->action = isset($url[1]) ? $url[1]: 'index';
            
            unset($url[0], $url[1]); // delete this values from the url so that we can have parameters only
            
            // now add the parameters passed, to the prams array
            $this->prams = !empty($url) ? array_values($url) : [];
        }
    }   
}
