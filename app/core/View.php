<?php


class View {
    //put your code here
    
    protected $view_file;//stores the name of the html file that need to be displayed
    protected $view_data;// stores the data that has been sent to the page
    
    public function __construct($view_file, $view_data) {
        $this->view_data = $view_data;
        $this->view_file = $view_file;
    }
    
    /**
     * Display the page(view) in the browser by
     * including it
     */
    public function render() {
        // check if the file exist
        if(file_exists(VIEW . $this->view_file . '.phtml')) {
            include VIEW . $this->view_file . '.phtml';
        } else {
            echo '<b>Seems this page has been deleted or doesn\'t exist!!</b><br>';
        }
        
        //var_dump($this->view_data);
    }
    
    public function getAction() {
        return (explode('\\', $this->view_file)[1]);
    }
    
    public function getController() {
        return (explode('\\', $this->view_file)[0]);
    }
    
    public function addViewData($key, $value) {
        $this->view_data[$key] = $value;
    }
    
}
