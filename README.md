gii-migration
=============

A Yii2 Gii Code Generator to create basic new table migrations easily.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

```
"wilwade/gii-migration": "dev-master"
```

## Usage

```php
//if your gii modules configuration looks like below:
    $config['modules']['gii'] = 'yii\gii\Module';
// Replace this line
```

```php
//Add this into common/config/main-local.php
    $config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		'generators' => [
			'giiMigration' => [
				'class' => 'wilwade\giiMigration\generators\migration\Generator',
				//Optional:
				'defaultColumns' => [],
				'baseClass' => 'yii\db\Migration',
			],
		],
    ],
```

## Optional Config

* defaultColumns: Used to have an array of columns that will be added if the include default columns checkbox is checked
* baseClass: Used if you want to extend something besides the default Migration class
