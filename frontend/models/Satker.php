<?php

namespace frontend\models;

use Yii;
																		
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "ref_satker".
 *

 * @property integer $id
 * @property string $name
 * @property string $shortname
 * @property string $letterNumber
 * @property integer $eselon
 * @property string $address
 * @property string $city
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property integer $status
 * @property string $created
 * @property integer $createdBy
 * @property string $modified
 * @property integer $modifiedBy
 * @property string $deleted
 * @property integer $deletedBy
 *
 * @property Employee[] $employees
 * @property Meeting[] $meetings
 * @property Program[] $programs
 * @property ProgramHistory[] $programHistories
 * @property Room[] $rooms
 * @property SatkerPic[] $satkerPics
 * @property Training[] $trainings
 * @property TrainingHistory[] $trainingHistories
 */
class Satker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_satker';
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
            [['id', 'name', 'letterNumber'], 'required'],
            [['id', 'eselon', 'status', 'createdBy', 'modifiedBy', 'deletedBy'], 'integer'],
            [['created', 'modified', 'deleted'], 'safe'],
            [['name', 'website'], 'string', 'max' => 255],
            [['shortname', 'city', 'phone', 'fax'], 'string', 'max' => 50],
            [['letterNumber'], 'string', 'max' => 25],
            [['address'], 'string', 'max' => 500],
            [['email'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'shortname' => 'Shortname',
            'letterNumber' => 'Letter Number',
            'eselon' => 'Eselon',
            'address' => 'Address',
            'city' => 'City',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'website' => 'Website',
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
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['ref_satker_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeetings()
    {
        return $this->hasMany(Meeting::className(), ['ref_satker_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['ref_satker_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramHistories()
    {
        return $this->hasMany(ProgramHistory::className(), ['ref_satker_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['ref_satker_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatkerPics()
    {
        return $this->hasMany(SatkerPic::className(), ['ref_satker_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['ref_satker_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingHistories()
    {
        return $this->hasMany(TrainingHistory::className(), ['ref_satker_id' => 'id']);
    }
}
