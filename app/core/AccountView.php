<?php


class AccountView extends View{
    //put your code here
    
    private $user = null;
    /**
     * Constructor for AccountView
     * @param type $view_file
     * @param type $view_data
     */
    public function __construct($view_file, $view_data) {
        parent::__construct($view_file, $view_data);
        $this->user = $view_data['user'];
    }
}