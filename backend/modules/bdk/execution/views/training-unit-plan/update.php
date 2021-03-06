<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TrainingUnitPlan */

$this->title = 'Update Training Unit Plan: ' . ' ' . $model->training->name;
$this->params['breadcrumbs'][] = ['label' => 'Training Unit Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->training->name, 'url' => ['view', 'id' => $model->tb_training_id]];
$this->params['breadcrumbs'][] = 'Update';
$controller = $this->context;
$menus = $controller->module->getMenuItems();
$this->params['sideMenu'][$controller->module->uniqueId]=$menus;

echo \kartik\widgets\AlertBlock::widget([
    'useSessionFlash' => true,
    'type' => \kartik\widgets\AlertBlock::TYPE_ALERT
]);
?>
<div class="training-unit-plan-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
