<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','heart'],
    'modules' => [
		/* START SEKRETARIAT */
		'sekretariat-organisation' => [
            'class' => 'backend\modules\sekretariat\organisation\Module',
        ],
		'eregistrasi-training' => [
            'class' => 'frontend\modules\eregistrasi\trainingclass\Module',
        ],
		'sekretariat-hrd' => [
            'class' => 'backend\modules\sekretariat\hrd\Module',
        ],
		'sekretariat-finance' => [
            'class' => 'backend\modules\sekretariat\finance\Module',
        ],
		'sekretariat-it' => [
            'class' => 'backend\modules\sekretariat\it\Module',
        ],
		'sekretariat-general' => [
            'class' => 'backend\modules\sekretariat\general\Module',
        ],
		/* FINISH SEKRETARIAT */
		/* START PUSDIKLAT */
		'pusdiklat-general' => [
            'class' => 'backend\modules\pusdiklat\general\Module',
        ],
		'pusdiklat-planning' => [
            'class' => 'backend\modules\pusdiklat\planning\Module',
        ],
		'pusdiklat-execution' => [
            'class' => 'backend\modules\pusdiklat\execution\Module',
        ],
		'pusdiklat-evaluation' => [
            'class' => 'backend\modules\pusdiklat\evaluation\Module',
        ],
		/* FINISH PUSDIKLAT */				
		/* START PUSDIKLAT2 */
		'pusdiklat2-general' => [
            'class' => 'backend\modules\pusdiklat2\general\Module',
        ],
		'pusdiklat2-training' => [
            'class' => 'backend\modules\pusdiklat2\training\Module',
        ],
		'pusdiklat2-test' => [
            'class' => 'backend\modules\pusdiklat2\test\Module',
        ],
		'pusdiklat2-scholarship' => [
            'class' => 'backend\modules\pusdiklat2\scholarship\Module',
        ],
		/* FINISH PUSDIKLAT2 */
		/* START BDK */
		'bdk-general' => [
            'class' => 'backend\modules\bdk\general\Module',
        ],
		'bdk-execution' => [
            'class' => 'backend\modules\bdk\execution\Module',
        ],
		'bdk-evaluation' => [
            'class' => 'backend\modules\bdk\evaluation\Module',
        ],
		/* FINSIH BDK */
		'heart' => [
            'class' => 'hscstudio\heart\Module',
            'features'=>[
				'datecontrol'=>true,// use false for not use it
				'gridview'=>true,// use false for not use it
				'gii'=>true, // use false for not use it
				'privilege'=>[
					'allowActions' => [
						/* DEFAULT */
						'debug/*',
						'site/*',
						'gii/*',
						'user/*',
						'privilege/*',
						'gridview/*',	// add or remove allowed actions to this list
						'file/*',
						/* DEFAULT */						
						/* START SEKRETARIAT */
						'sekretariat-organisation/*',
						'sekretariat-hrd/*',
						'sekretariat-finance/*',
						'sekretariat-it/*',
						'sekretariat-general/*',
						/* FINISH SEKRETARIAT */
						/* START PUSDIKLAT */
						'pusdiklat-general/*',
						'pusdiklat-planning/*',
						'pusdiklat-execution/*',
						'pusdiklat-evaluation/*',
						/* FINISH PUSDIKLAT */
						/* START PUSDIKLAT2 */
						'pusdiklat2-general/*',
						'pusdiklat2-training/*',
						'pusdiklat2-test/*',
						'pusdiklat2-scholarship/*',
						/* FINISH PUSDIKLAT2 */
						/* START BDK */
						'bdk-general/*',
						'bdk-execution/*' ,
						'bdk-evaluation/*' ,
						/* FINISH BDK */
					],
					'authManager' => [
					  'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
					]
				],
				'user'=>true,
            ]
        ],
		'user'=>[
			'class' => '\dektrium\user\Module',
			'components' => [
				'manager' => [
					// Active record classes
					'userClass' => 'backend\models\User',
					'profileClass' => 'backend\models\Employee',
					//'userClass'    => 'dektrium\user\models\User',
					//'profileClass' => 'dektrium\user\models\Profile',
					//'accountClass' => 'dektrium\user\models\Account',
					// Model that is used on resending confirmation messages
					//'resendFormClass' => 'dektrium\user\models\ResendForm',
					// Model that is used on logging in
					//'loginFormClass' => 'dektrium\user\models\LoginForm',
					// Model that is used on password recovery
					//'passwordRecoveryFormClass' => 'dektrium\user\models\RecoveryForm',
					// Model that is used on requesting password recovery
					//'passwordRecoveryRequestFormClass' => 'dektrium\user\models\RecoveryRequestForm',
				],
			], 
			'controllerMap' => [
				'admin' => 'backend\controllers\AdminController'
			],					
			'confirmable' => false,
			'confirmWithin' =>  86400, 
			'allowUnconfirmedLogin' => false,
			'rememberFor' => 1209600,
			'recoverWithin' => 21600,
			'admins' => ['admin'],
			'cost' => 13,
		],		
	],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
			'identityCookie' => [
				  'name' => '_backendUser', // unique for frontend
				  'path'=>'/syawwal/backend'  // correct path for the frontend app.
			  ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
		],
    ],
    'params' => $params,
];
