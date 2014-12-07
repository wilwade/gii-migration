<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */

echo "<?php\n";
?>

use yii\db\Schema;
use yii\db\Migration;

class <?= $className ?> extends Migration
{
    public function up()
    {
		$this->createTable(<?=$generator->tableName;?>, [
			<?php foreach($generator->columns as $key => $column):?>
				'<?=$column;?>' => '<?=$column;?>',
			<?php endforeach;?>
		]);
    }

    public function down()
    {
        $this->dropTable('<?=$generator->tableName;?>');
    }
}
