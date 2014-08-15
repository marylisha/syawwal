<?php

namespace backend\modules\bdk\execution;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\bdk\execution\controllers';

    public function init()
    {
        parent::init();
    }
	
	public function getMenuItems(){
		return [
			['icon'=>'fa fa-fw fa-dashboard','label' => 'Dashboard', 'url' => ['/'.$this->uniqueId.'/default']],
			['icon'=>'fa fa-fw fa-stack-overflow','label' => 'Training', 'url' => ['/'.$this->uniqueId.'/training/index'], 'path' => 'training'],
			['icon'=>'fa fa-fw fa-users', 'label' => 'Trainer', 'url' => ['/'.$this->uniqueId.'/trainer/index'], 'path' => 'trainer'],
			['icon'=>'fa fa-fw fa-child', 'label' => 'Student', 'url' => ['/'.$this->uniqueId.'/student/index'], 'path' => 'student'],
		];
	}
}