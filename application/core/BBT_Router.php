<?php

class BBT_Router extends CI_Router
{
    public function __construct()
    {
        parent::__construct();
        
        // register the autoloader
        spl_autoload_register(array('BBT_Router', '__autoloader'));
    }

    /**
     * Autoloader for libraries, abstracts, interfaces and RapidDataMapper data objects
     *
     * @param  string
     * @return void
     */
    public static function __autoloader($class)
    {
        // For security reasons only allow alphanumeric chars and underscores
        $class = preg_replace('/([^a-zA-Z0-9_]*)/', '', $class);

        // Don't autoload CI_ or MY_ prefixed classes, leave that to CI
        if (substr($class, 0, 3) == 'CI_' || substr($class, 0, 3) == 'BBT_' || $class == 'Model')
            return;

		//Load
        elseif (file_exists(APPPATH.'libraries/'.$class.EXT))
        {
            require(APPPATH.'libraries/'.$class.EXT);
            return;
		}
    }
    // ------------------------------------------------------------------------
}

