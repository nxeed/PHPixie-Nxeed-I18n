<?php

namespace PHPixie;

/**
 * Module for using internationalization
 *
 * @author Nxeed
 * @link https://github.com/nxeed/PHPixie-Nxeed-I18n Download this module from Github
 */
class I18n {

    /**
     * Pixie Dependency Container
     * 
     * @var \PHPixie\Pixie
     */
    protected $pixie;

    /**
     * Used files
     * 
     * @var array
     */
    protected $files;
    
    /**
     * Initializes the I18n module
     * 
     * @param \PHPixie\Pixie $pixie Pixie dependency container
     */
    public function __construct($pixie) {
        $this->pixie = $pixie;
    }

}
