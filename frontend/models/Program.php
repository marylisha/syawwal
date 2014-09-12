<?php

namespace frontend\models;

use Yii;
																				
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "tb_program".
 *

 * @property integer $id
 * @property integer $ref_satker_id
 * @property string $number
 * @property string $name
 * @property string $hours
 * @property integer $days
 * @property integer $test
 * @property integer $type
 * @property string $note
 * @property integer $validationStatus
 * @property string $validationNote
 * @property string $category
 * @property string $stage
 * @property integer $status
 * @property string $created
 * @property integer $createdBy
 * @property string $modified
 * @property integer $modifiedBy
 * @property string $deleted
 * @property integer $deletedBy
 *
 * @property Satker $refSatker
 * @property ProgramDocument[] $programDocuments
 * @property ProgramHistory[] $programHistories
 * @property ProgramSubject[] $programSubjects
 * @property ProgramSubjectHistory[] $programSubjectHistories
 * @property Training[] $trainings
 * @property TrainingHistory[] $trainingHistories
 */
class Program extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_program';
    }
	
    /**
     * @inheritdoc
     */	
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                        \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created','modified'],
                        \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'modified',
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                        \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['createdBy','modifiedBy'],
                        \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'modifiedBy',
                ],
            ],
        ];
    }
	

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref_satker_id', 'days', 'test', 'type', 'validationStatus', 'status', 'createdBy', 'modifiedBy', 'deletedBy'], 'integer'],
            [['name', 'category', 'stage'], 'required'],
            [['hours'], 'number'],
            [['created', 'modified', 'deleted'], 'safe'],
            [['number'], 'string', 'max' => 15],
            [['name', 'note', 'validationNote'], 'string', 'max' => 255],
            [['category', 'stage'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_satker_id' => 'Ref Satker ID',
            'number' => 'Number',
            'name' => 'Name',
            'hours' => 'Hours',
            'days' => 'Days',
            'test' => 'Test',
            'type' => 'Type',
            'note' => 'Note',
            'validationStatus' => 'Validation Status',
            'validationNote' => 'Validation Note',
            'category' => 'Category',
            'stage' => 'Stage',
            'status' => 'Status',
            'created' => 'Created',
            'createdBy' => 'Created By',
            'modified' => 'Modified',
            'modifiedBy' => 'Modified By',
            'deleted' => 'Deleted',
            'deletedBy' => 'Deleted By',
        ];
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatker()
    {
        return $this->hasOne(Satker::className(), ['id' => 'ref_satker_id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramDocuments()
    {
        return $this->hasMany(ProgramDocument::className(), ['tb_program_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramHistories()
    {
        return $this->hasMany(ProgramHistory::className(), ['tb_program_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramSubjects()
    {
        return $this->hasMany(ProgramSubject::className(), ['tb_program_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramSubjectHistories()
    {
        return $this->hasMany(ProgramSubjectHistory::className(), ['tb_program_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['tb_program_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingHistories()
    {
        return $this->hasMany(TrainingHistory::className(), ['tb_program_id' => 'id']);
    }
}
