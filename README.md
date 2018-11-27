## Cakestrap
A Twitter Bootstrap plugin for CakePHP 3.+

#### API Documentation
You can read the API documentation

#### Requirements
- CakePHP version >= 2.+
- Php >=5.4
- Composer

#### Installation
You can get this plugin using composer or by cloning the repository.

###### Using Composer:
1.) You'll need to download and install Composer if you haven't done so already. 
  ```php
curl -s https://getcomposer.org/installer | php
 ```
2.) On your CakePHP app navigate to src/plugins folder.

3.) Get this plugin by running the codes in console:
  ```php
composer require cmnworks/cakestrap
 ```
###### Cloning Repository:
  - Navigate to your CakePHP src/plugins directory
  - Clone the repository using this link https://github.com/cmnworks/Cakestrap.git
 
#### Configuration
  - Locate your src/config folder.
  - Open the bootstrap.php file with your favorite editor.
  - At the very bottom of the file, load the plugin by using the codes below

```php
Plugin::load('Cakestrap', ['bootstrap' => true,  'routes' => true]);
```
src/Template/Layout/default.ctp
###### Bootstrap Asset
Add the codes below inside html head.
```php
<head>
<?php echo $this->Cakestrap->Asset()->style()?>
</head>
 ```
 Add the codes below before body end tag.
```php
<?php echo $this->Cakestrap->Asset()->script()?>
 </body>
 ```
###### Example:
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $this->Cakestrap->Asset()->style()?>
  </head>
<body>
<?php echo $this->fetch('content')?>
<?php echo $this->Cakestrap->Asset()->script()?>
</body>
</html>
```
src/Controller/UsersController.php

Declare the plugin to var $helpers

```php
public $helpers = ['Cakestrap.Cakestrap'];
 ```
 
###### Example:
```php
<?php
namespace App\Controller;
class UsersController extends AppController
{
    public $helpers = ['Cakestrap.Cakestrap'];
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout('default');
    }
    public function index() 
    {
    }
}
```

src/Template/Users/index.ctp
```php
 <?php
 echo $this->Cakestrap->Tab()
                      ->nav('Tab 1')
                      ->content("This Tab 1  needs your attention.")
                      ->prepare($isActive = true)

                      ->nav('Tab 2')
                      ->content("This Tab 2 needs your attention.")
                      ->prepare()

                      ->set()
 ?>
```

###### Autoloading Plugin Classes:
Modify your application�s composer.json file and add the Bootstrap plugin details like the following information below.
```php
   "autoload": {
        "psr-4": {
			"Cakestrap\\": "./plugins/Cakestrap/src"
        }
    },
```
Additionally, you will need to tell Composer to refresh its autoloading cache:
```php
$ php composer.phar dumpautoload
```