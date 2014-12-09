<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\form\Generator */

$i = '';
$columnRow = '<div class="gii-migration-column-row well well-sm clearfix">'
	.'<div class="col-sm-6">'.$form->field($generator, 'columns['.$i.']', ['inputOptions' => ['class' => 'form-control gii-migration-columns-input', 'id' => '', ]]).'</div>'
	.'<div class="col-sm-6">'.$form->field($generator, 'types['.$i.']', ['inputOptions' => ['class' => 'form-control', 'id' => '', ]]).'</div>'
	.'</div>';

$jsColumnRow = json_encode($columnRow);
$script = <<< JS
$('#gii-migration-columns').on('focus', 'input', function(e) {
	var giiMigrationColumnRowTemplate = {$jsColumnRow};
    //See if there is an empty column at the end. If not add one.
	var lastColumn = $('#gii-migration-columns .gii-migration-columns-input').last();
	if(lastColumn.val() !== '' || lastColumn.is(':focus')){
		//Append another row.
		$('#gii-migration-columns').append(giiMigrationColumnRowTemplate);
	}
});
JS;
$this->registerJs($script);

echo $form->field($generator, 'tableName');
echo $form->field($generator, 'includeDefaultColumns')->checkbox();
?>
<div class="hidden">
	<?=$form->field($generator, 'migrationClassName')->hiddenInput();?>
</div>
<div id="gii-migration-columns" class='clearfix'>
<?php
if(count($generator->columns) > 0)
{
	foreach($generator->columns as $i => $column)
	{
		echo '<div class="gii-migration-column-row well well-sm clearfix">'
			.'<div class="col-sm-6">'.$form->field($generator, 'columns['.$i.']', ['inputOptions' => ['class' => 'form-control gii-migration-columns-input', 'id' => '', ]]).'</div>'
			.'<div class="col-sm-6">'.$form->field($generator, 'types['.$i.']', ['inputOptions' => ['class' => 'form-control', 'id' => '', ]]).'</div>'
			.'</div>';
	}
}
else{
	echo $columnRow;
}
?>

</div>