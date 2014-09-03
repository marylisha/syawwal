<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Meeting */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="meeting-form">
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="pull-right">
		<?= Html::a('<i class="fa fa-arrow-left"></i> BACK',['index'],
						['class'=>'btn btn-xs btn-primary',
						 'title'=>'Back to Index',
						]) ?>
		</div>
		<i class="fa fa-fw fa-globe"></i> 
		Meeting	</div>
	<div style="margin:10px">
    <?php $form = ActiveForm::begin([
		//'type' => ActiveForm::TYPE_HORIZONTAL,
		'options'=>['enctype'=>'multipart/form-data']
	]); ?>
	<?= $form->errorSummary($model) ?>
	<div class="row">
	<div class="col-md-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($model, 'note')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'startTime')->widget(\kartik\datecontrol\DateControl::classname(), [
					'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
				]); ?>
    <?= $form->field($model, 'finishTime')->widget(\kartik\datecontrol\DateControl::classname(), [
					'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
				]); ?>
	</div>
	<div class="col-md-6">
    <?= $form->field($model, 'attendanceCount')->textInput() ?>
	
	<?php 
	if ($model->isNewRecord) {
		echo $form->field($model, 'classCount')->textInput(['maxlength' => 3, 'value'=>'1']);
	}
	else{
		echo $form->field($model, 'classCount')->textInput(['maxlength' => 3]);
	}
	?>

    <?= $form->field($model, 'hostel')->widget(\kartik\widgets\SwitchInput::classname(), [
					'pluginOptions' => [
						'onText' => 'On',
						'offText' => 'Off',
					]
				]) ?>

    <?= $form->field($model, 'status')->widget(\kartik\widgets\SwitchInput::classname(), [
					'pluginOptions' => [
						'onText' => 'On',
						'offText' => 'Off',
					]
				]) ?>  

    <?= $form->field($model, 'location')->textInput(['maxlength' => 255]) ?>
	</div>
	</div>
	
    <div class="clearfix"></div>

        <?= Html::submitButton(
			$model->isNewRecord ? '<span class="fa fa-fw fa-save"></span> '.'Create' : '<span class="fa fa-fw fa-save"></span> '.'Update', 
			['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

	
    <?php ActiveForm::end(); ?>
	</div>
</div>
</div>
