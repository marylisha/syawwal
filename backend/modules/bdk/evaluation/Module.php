<?php

namespace backend\modules\bdk\evaluation;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\bdk\evaluation\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
	
	public function getMenuItems(){
		return [
			['icon'=>'dashboard','label' => 'Dashboard', 'url' => ['/'.$this->uniqueId.'/default']],
			// Add here your items module
			//['label' => 'Employee', 'url' => ['/'.$this->uniqueId.'/employee/index']],
		];
	}
}
