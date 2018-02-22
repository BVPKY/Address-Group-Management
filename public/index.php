
        <?php
        
        define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
        define('APP',        ROOT . 'app' . DIRECTORY_SEPARATOR);
        define('VIEW',       ROOT . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
        define('MODEL',      ROOT . 'app' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR);
        define('CONTROLLER', ROOT . 'app' . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR);
        define('CORE',       ROOT . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR);
        define('DATA',       ROOT . 'app' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
        
        define('HOST',     'http://localhost/');
        define('ASSETS',     HOST . 'assets' . DIRECTORY_SEPARATOR);
        define('CSS',       ASSETS . 'css' . DIRECTORY_SEPARATOR);
        define('IMAGES',       ASSETS . 'images' . DIRECTORY_SEPARATOR);
        define('JS',       ASSETS . 'js' . DIRECTORY_SEPARATOR);
        
        // when ever we are using a class in any file, we have to 
        // include its source in our file
        // so inorder to do that automatically we use autoload 
        // include path option will do that work for us
        // first create an array of paths defined above
        $modules = [ROOT, APP, CORE, CONTROLLER, DATA, ASSETS];
        
        // now append these modules to the default include path
        set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));
        
        // NOW CALL THE AUTO LOAD FUNCTION
        spl_autoload_register('spl_autoload', false);

        // instantiate the application object
        new Application();
        