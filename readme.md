Internationalization Module for PHPixie
=========

How to install?
----

* Add my repository to your *composer.json*

```
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/nxeed/PHPixie-Nxeed-I18n"
    }
],
```
* Add package in "require" section of *composer.json*

```
"phpixie/nxeed-i18n": "2.*@dev"
```
* Update your vendors

```
php composer.phar update -o  --prefer-dist
```

How to use?
----

* Add a config file under */assets/config/i18n.php*
* Define default language and language list of the application

```
return array(
    'default' => 'ru',
    'list' => array('ru', 'en')
);
```

* Define module in your *Pixie.php*

```
protected $modules = array(
    'i18n' => '\PHPixie\I18n'
);
```

* In "after_bootstrap" call the "run" method from the class of module

```
protected function after_bootstrap() {
    $this->i18n->run();
}
```

* Create translation files under */assets/i18n/<section name>* with names *<lang_alias>.xml*
* To get translation use "get" method from module class

```
$pixie->i18n->get('main')->footer->copyright->author
```
