<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */

$columns = array_combine($generator->columns, $generator->types);
if ($generator->includeDefaultColumns === '1') {
	$columns = array_merge($generator->defaultColumns, $columns);
}
$foreignKeys = [];
foreach($generator->columns as $key => $column):
	if(substr($column, -3) === '_id'):
		$refTable = substr($column, 0, -3);
		$foreignKeys[$column] = $refTable;
	endif;
endforeach;

echo "<?php\n";
?>

use yii\db\Schema;
use yii\db\Migration;

class <?= $className ?> extends Migration
{
    public function up()
    {
		$this->createTable(<?=$generator->tableName;?>, [
<?php foreach($columns as $column => $type):?>
			'<?=$column;?>' => '<?=$type;?>',
<?php endforeach;?>
		]);
<?php foreach($foreignKeys as $column => $refTable):?>
		$this->addForeignKey( '<?=$generator->tableName;?>_<?=$column;?>_fk', '<?=$generator->tableName;?>', '<?=$column;?>', '<?=$refTable;?>', 'id', 'RESTRICT', 'CASCADE' );
<?php endforeach;?>
    }

    public function down()
    {
<?php foreach($foreignKeys as $column => $refTable):?>
		$this->dropForeignKey( '<?=$generator->tableName;?>_<?=$column;?>_fk', '<?=$generator->tableName;?>');
<?php endforeach;?>
        $this->dropTable('<?=$generator->tableName;?>');
    }
}
