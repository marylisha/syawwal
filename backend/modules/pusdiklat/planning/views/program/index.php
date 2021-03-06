<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Dropdown;
use kartik\widgets\Select2;

/* @var $searchModel backend\models\ProgramSearch */

$this->title = 'Programs';
$this->params['breadcrumbs'][] = $this->title;

$controller = $this->context;
$menus = $controller->module->getMenuItems();
$this->params['sideMenu'][$controller->module->uniqueId]=$menus;
?>
<div class="program-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<?php \yii\widgets\Pjax::begin([
		'id'=>'pjax-program-gridview',
	]); ?>
	
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
			[
				'class' => 'kartik\grid\EditableColumn',
				'attribute' => 'number',
				'width'=>'80px',
				'vAlign'=>'middle',
				'headerOptions'=>['class'=>'kv-sticky-column'],
				'contentOptions'=>['class'=>'kv-sticky-column'],
				'editableOptions'=>['header'=>'Number', 'size'=>'md','formOptions'=>['action'=>\yii\helpers\Url::to('editable')]]
			],
            
			[
				'class' => 'kartik\grid\EditableColumn',
				'attribute' => 'name',
				'format'=>'raw',
				'vAlign'=>'middle',
				'hAlign'=>'left',
				'headerOptions'=>['class'=>'kv-sticky-column'],
				'contentOptions'=>['class'=>'kv-sticky-column'],
				'editableOptions'=>['header'=>'Name', 'size'=>'md','formOptions'=>['action'=>\yii\helpers\Url::to('editable')]],
				'value' => function ($data){
					return Html::a($data->name,'#',['title'=>$data->note,'data-toggle'=>"tooltip",'data-placement'=>"top"]);
				},
			],
            
			[
				'class' => 'kartik\grid\EditableColumn',
				'attribute' => 'hours',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'width'=>'80px',
				'headerOptions'=>['class'=>'kv-sticky-column'],
				'contentOptions'=>['class'=>'kv-sticky-column'],
				'editableOptions'=>['header'=>'Hours', 'size'=>'md','formOptions'=>['action'=>\yii\helpers\Url::to('editable')]]
			],
		
			[
				'class' => 'kartik\grid\EditableColumn',
				'attribute' => 'days',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'width'=>'80px',
				'headerOptions'=>['class'=>'kv-sticky-column'],
				'contentOptions'=>['class'=>'kv-sticky-column'],
				'editableOptions'=>['header'=>'Days', 'size'=>'md','formOptions'=>['action'=>\yii\helpers\Url::to('editable')]]
			],
			[
				'format' => 'html',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'label' => 'Doc',
				'width'=>'80px',
				'value' => function ($data) {
					$countSubject = \backend\models\ProgramDocument::find()
								->where(['tb_program_id' => $data->id,])
								->active()
								->count();
					if($countSubject>0){
						return Html::a($countSubject, ['program-document/index','tb_program_id'=>$data->id], ['class' => 'label label-primary']);
					}
					else{
						return Html::a('+', ['program-document/index','tb_program_id'=>$data->id], ['class' => 'label label-primary']);
					}
				}
			],
			[
				'format' => 'html',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'label' => 'Rev',
				'width'=>'80px',
				'value' => function ($data) {
					$countRevision = \backend\models\ProgramHistory::find()
								->where(['tb_program_id' => $data->id,])
								->count()-1;
					if($countRevision>0){
						return Html::a($countRevision.'x', ['program-history/index','tb_program_id'=>$data->id], ['class' => 'label label-danger']);
					}
					else{
						return '-';
					}
				}
			],
			[
				'format' => 'html',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'label' => 'Subject',
				'width'=>'100px',
				'value' => function ($data) {
					$countSubject = \backend\models\ProgramSubject::find()
								->where(['tb_program_id' => $data->id,])
								->active()
								->count();
					if($countSubject>0){
						return Html::a($countSubject, ['program-subject/index','tb_program_id'=>$data->id], ['class' => 'label label-success']);
					}
					else{
						return Html::a('+', ['program-subject/index','tb_program_id'=>$data->id], ['class' => 'label label-success']);
					}
				}
			],
			[
				'format' => 'raw',
				'attribute' => 'status',
				'vAlign'=>'middle',
				'hAlign'=>'center',
				'width'=>'80px',
				'headerOptions'=>['class'=>'kv-sticky-column'],
				'contentOptions'=>['class'=>'kv-sticky-column'],
				'value' => function ($data){
					$icon = ($data->status==1)?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>';
					return Html::a($icon, ['status','status'=>$data->status, 'id'=>$data->id], [
						'onclick'=>'
							$.pjax.reload({url: "'.\yii\helpers\Url::to(['status','status'=>$data->status, 'id'=>$data->id]).'", container: "#pjax-gridview", timeout: 3000});
							return false;
						',
						'class'=>($data->status==1)?'label label-info':'label label-warning',
					]);
					
				}
			],
			
            [
				'class' => 'kartik\grid\ActionColumn',
				'buttons' => [
					'view' => function ($url, $model) {
						$icon='<span class="glyphicon glyphicon-eye-open"></span>';
						return Html::a($icon,$url,['class'=>'modal-heart','data-pjax'=>"0",'source'=>'.table-responsive','title'=>$model->name]);
					},
					'update' => function ($url, $model) {
						$icon='<span class="glyphicon glyphicon-pencil"></span>';
						return Html::a($icon,$url,['class'=>'modal-heart','data-pjax'=>"0",]);
					},
				],
			],
        ],
		'panel' => [
			//'heading'=>'<h3 class="panel-title"><i class="fa fa-fw fa-globe"></i> Program</h3>',
			'heading'=>'<h3 class="panel-title"><i class="fa fa-fw fa-globe"></i></h3>',
			//'type'=>'primary',
			'before'=>
				Html::a('<i class="fa fa-fw fa-plus"></i> Create Program', ['create'], ['class' => 'btn btn-success']). ' '.
				'<div class="pull-right" style="margin-right:5px;">'.
				Select2::widget([
					'name' => 'status', 
					'data' => ['1'=>'Published','0'=>'Unpublished','all'=>'All'],
					'value' => $status,
					'options' => [
						'placeholder' => 'Status ...', 
						'class'=>'form-control', 
						'onchange'=>'
							$.pjax.reload({
								url: "'.\yii\helpers\Url::to(['/'.$controller->module->uniqueId.'/program/index']).'?status="+$(this).val(), 
								container: "#pjax-program-gridview", 
								timeout: 1,
							});
						',	
					],
				]).
				'</div>',
			'after'=>
				Html::a('<i class="fa fa-fw fa-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info', 'data-pjax'=>'0']),
			'showFooter'=>false
		],
		'responsive'=>true,
		'hover'=>true,
    ]); 
	?>
	<?php \yii\widgets\Pjax::end(); ?>
	
	<?php
	$initScript = '
	 $("a.modal-heart").on("click", function () {
		var $modal = $("#modal-heart");
		$.ajax({
			type: "POST",
			cache: false,
			url: $(this).attr("href"), 
			success: function (data) {
				$modal.find(".modal-body").html(data);
			}
		});		
		$modal.modal("show");
		return false;
	 });
	';
	//$this->registerJS($initScript);
	echo \hscstudio\heart\widgets\Modal::widget(['modalSize'=>'modal-lg']);
	?>
	<?php 	
	echo Html::beginTag('div', ['class'=>'row']);
		echo Html::beginTag('div', ['class'=>'col-md-2']);
			echo Html::beginTag('div', ['class'=>'dropdown']);
				echo Html::button('PHPExcel <span class="caret"></span></button>', 
					['type'=>'button', 'class'=>'btn btn-default', 'data-toggle'=>'dropdown']);
				echo Dropdown::widget([
					'items' => [
						['label' => 'EXport XLSX', 'url' => ['php-excel?filetype=xlsx&template=yes']],
						['label' => 'EXport XLS', 'url' => ['php-excel?filetype=xls&template=yes']],
						['label' => 'Export PDF', 'url' => ['php-excel?filetype=pdf&template=no']],
					],
				]); 
			echo Html::endTag('div');
		echo Html::endTag('div');
	
		echo Html::beginTag('div', ['class'=>'col-md-2']);
			echo Html::beginTag('div', ['class'=>'dropdown']);
				echo Html::button('OpenTBS <span class="caret"></span></button>', 
					['type'=>'button', 'class'=>'btn btn-default', 'data-toggle'=>'dropdown']);
				echo Dropdown::widget([
					'items' => [
						['label' => 'EXport DOCX', 'url' => ['open-tbs?filetype=docx']],
						['label' => 'EXport ODT', 'url' => ['open-tbs?filetype=odt']],
						['label' => 'EXport XLSX', 'url' => ['open-tbs?filetype=xlsx']],
					],
				]); 
			echo Html::endTag('div');
		echo Html::endTag('div');
		
		echo Html::beginTag('div', ['class'=>'col-md-8']);
			$form = \yii\bootstrap\ActiveForm::begin([
				'options'=>['enctype'=>'multipart/form-data'],
				'action'=>['import'],
			]);
			echo \kartik\widgets\FileInput::widget([
				'name' => 'importFile', 
				//'options' => ['multiple' => true], 
				'pluginOptions' => [
					'previewFileType' => 'any',
					'uploadLabel'=>"Import Excel",
				]
			]);
			\yii\bootstrap\ActiveForm::end();
		echo Html::endTag('div');
		
	echo Html::endTag('div');
	?>

</div>
