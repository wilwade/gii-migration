<?php
/**
 * @link http://www.github.com/wilwade/gii-migration
 * @copyright Copyright (c) 2014 Wil Wade
 * @license http://www.yiiframework.com/license/
 */

namespace wilwade\giimigration\generators\migration;

use Yii;
use yii\db\Migration;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\base\NotSupportedException;

/**
 * This generator will generate one or multiple ActiveRecord classes for the specified database table.
 */
class Generator extends \yii\gii\Generator
{
	/**
	 * The class to extend from
	 * @var string
	 */
	public $baseClass = 'yii\db\Migration';
	
	/**
	 * Default columns to include using the standard Yii migration syntax
	 * @var array
	 */
	public $defaultColumns = [];
	
	public $includeDefaultColumns = 1;
	public $tableName;
	public $columns;
	public $types;
	public $migrationPath = '@console/migrations';
	public $migrationClassName;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Migration Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator will give you an easy form that will create safe up and down migrations for a new table.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['tableName', 'baseClass'], 'filter', 'filter' => 'trim'],
            [['tableName', 'columns', 'types', 'includeDefaultColumns', ], 'required'],
            [['tableName', ], 'match', 'pattern' => '/^\w+$/', 'message' => 'Only word characters are allowed.'],
			[['migrationClassName'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
			'tableName' => 'Table Name',
			'includeDefaultColumns' => 'Include Default Columns',
            'columns' => 'Database Column Name',
			'types' => 'Column Type',
            'baseClass' => 'Base Class',
			'migrationClassName' => 'Migration Class Name to keep time',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
			'tableName' => 'The Name of the new Table (will create migration m#####_####_create_TABLE_NAME)',
			'includeDefaultColumns' => 'Default columns are defined in the configuration for the gii module',
            'baseClass' => 'This is the base class of the new ActiveRecord class. It should be a fully qualified namespaced class name.',
			'columns' => 'The names of the columns',
			'types' => 'Database Types like Yii versions of string, int, or database types such as varchar. See Yii values: <a href="http://www.yiiframework.com/doc-2.0/yii-db-schema.html">http://www.yiiframework.com/doc-2.0/yii-db-schema.html</a>',
		]);
    }

    /**
     * @inheritdoc
     */
    public function autoCompleteData()
    {
		return [
			//From Schema constants
			'types' => [
				'pk',
				'bigpk',
				'string',
				'text',
				'smallint',
				'integer',
				'bigint',
				'float',
				'decimal',
				'datetime',
				'timestamp',
				'time',
				'date',
				'binary',
				'boolean',
				'money',
			],
		];
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['migration.php',];
    }
	
	/**
	 * @inheritdoc
	 */
	public function beforeValidate()
	{
		if(is_array($this->columns)){
			$this->columns = array_filter($this->columns, function($v){return $v !== '';});
		}
		if(is_array($this->types)){
			$this->types = array_filter($this->types, function($v){return $v !== '';});
		}
		$this->getMigrationClassName();
		return parent::beforeValidate();
	}

    /**
     * @inheritdoc
     */
    public function generate()
    {
		$name = $this->getMigrationClassName();
        $file = $this->migrationPath . DIRECTORY_SEPARATOR . $name . '.php';
		
        $files = [];
		$params = [
			'generator' => $this,
			'className' => $name,
		];
		$files[] = new CodeFile(
			Yii::getAlias($file),
			$this->render('migration.php', $params)
		);

        return $files;
    }
	
	public function getMigrationClassName()
	{
		if($this->migrationClassName)
		{
			return $this->migrationClassName;
		}
		$this->migrationClassName = 'm' . gmdate('ymd_His') . '_create_' . $this->tableName;
	}
}
