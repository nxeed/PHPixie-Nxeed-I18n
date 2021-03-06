I18n Module for PHPixie
=========

Just little "crutch" for using internationalization in PHPixie

* Automatically URL modification
* XML for translations
* Very simple to use

How to install?
----

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
* Define default language and language list of your application

```
return array(
    'default' => 'ru',
    'list' => array('ru', 'en')
);
```

* Define this in your *Pixie.php*

```
protected $modules = array(
    'i18n' => '\PHPixie\I18n'
);
```

* Call the "run" method from "after_bootstrap" of your *Pixie.php*

```
protected function after_bootstrap() {
    $this->i18n->run();
}
```

* Create translation files under */assets/i18n/%section name%* with names *%lang alias%.xml*
* Use "get" method to get necessary translations

```
$i18n = $this->pixie->i18n->get('main');
$this->view->title = $i18n->site->title;
```
