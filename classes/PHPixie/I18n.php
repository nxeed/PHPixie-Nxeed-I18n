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
     * @var \PHPixie\Pixie
     */
    protected $pixie;

    /**
     * Module config data
     * @var array
     */
    protected $config;

    /**
     * Current language
     * @var string
     */
    public $lang;

    /**
     * List of available localization aliases
     * @var array
     */
    public $langList = array();

    /**
     * Real base URL of the application
     * @var string
     */
    protected $realBasepath;

    /**
     * Used files
     * @var array
     */
    protected $files = array();

    /**
     * Runs the module
     * (It's called after bootstrap)
     * 
     * @return \PHPixie\I18n
     */
    public function run() {
        $path = preg_replace("#^{$this->pixie->basepath}(?:index\.php/)?#i", '/', $_SERVER['REQUEST_URI']);
        $pathArr = explode('/', trim($path, '/'));

        $langPart = $pathArr[0];
        $langList = $this->langList;

        $langDefault = array_key_exists('lang', $_COOKIE) ? $_COOKIE['lang'] : $this->lang;

        if (!in_array($langPart, $langList)) {
            header("location: {$this->pixie->basepath}{$langDefault}{$path}");
            die();
        }

        $this->pixie->basepath = $this->pixie->basepath . $langPart . '/';

        setcookie('lang', $langPart, 604800 + time(), $this->realBasepath, $_SERVER['HTTP_HOST']);

        if ($path == '/' . $langPart) {
            header("location: {$this->pixie->basepath}");
            die();
        }

        $this->lang = $langPart;
        $this->routesRefresh();

        return $this;
    }

    /**
     * Get file data for current language from directory by specified name
     * 
     * @param string $name Directory name
     * @return \SimpleXMLElement
     * @throws \Exception If file doesn't exist
     */
    public function get($name) {
        $filePath = $this->pixie->find_file("i18n/{$name}", $this->lang, 'xml');

        if (!file_exists($filePath)) {
            throw new \Exception("File {$filePath} doesn't exist");
        }

        if (!array_key_exists($filePath, $this->files)) {
            $this->files[$name] = simplexml_load_file($filePath);
        }

        return $this->files[$name];
        
        
    }

    /**
     * Refresh routes
     * 
     * @return \PHPixie\I18n
     */
    protected function routesRefresh() {
        foreach ($this->pixie->config->get('routes') as $name => $rule) {
            $this->pixie->router->add($this->pixie->route($name, $rule[0], $rule[1], $this->pixie->arr($rule, 2, null)));
        }

        return $this;
    }

    /**
     * Initializes the I18n module
     * 
     * @param \PHPixie\Pixie $pixie Pixie dependency container
     */
    public function __construct($pixie) {
        $this->pixie = $pixie;
        $pixie->assets_dirs[] = dirname(dirname(dirname(__FILE__))) . '/assets/';

        $this->config = $this->pixie->config->get('i18n');

        $this->langList = $this->config['list'];
        $this->lang = $this->config['default'];
        $this->realBasepath = $this->pixie->basepath;
    }

}
