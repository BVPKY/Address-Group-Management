<?php

class Controller {
    //put your code here
    protected $view;
    protected $model;
    
    /**
     * 
     * @param type $viewName
     * @param type $data
     * @return type
     */
    public function view($viewName, $data=[]) {
        $this -> view = new View($viewName, $data);
        return $this->view;
    }
    
    public function model($modelName, $data=[]) {
        if(file_exists(MODEl . $modelName . 'php')) {
            require MODEl . $modelName . 'php';
            $this->model = new $modelName;
        }
    }

    /**
     * This method will append an AccountView object to the
     * view object in this class and returns that view object
     * @param type $viewName
     * @param type $data
     * @return \AccountView
     */
    public function accountView($viewName, $data=[]) {
        $this -> view = new AccountView($viewName, $data);
        return $this->view;
    }
}
