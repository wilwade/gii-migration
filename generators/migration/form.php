<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\form\Generator */

echo $form->field($generator, 'tableName');
echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'migrationClassName')->hiddenInput();

if(count($generator->columns) > 0)
{
	foreach($generator->columns as $i => $column)
	{
		echo $form->field($generator, 'columns['.$i.']');
	}
}
else{
	echo $form->field($generator, 'columns[]');

	echo $form->field($generator, 'columns[]');

	echo $form->field($generator, 'columns[]');
}


