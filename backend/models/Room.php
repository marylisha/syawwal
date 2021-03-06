<?php

namespace backend\models;

use Yii;
																
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "tb_room".
 *

 * @property integer $id
 * @property integer $ref_satker_id
 * @property string $code
 * @property string $name
 * @property integer $capacity
 * @property integer $owner
 * @property integer $computer
 * @property integer $hostel
 * @property string $address
 * @property integer $status
 * @property string $created
 * @property integer $createdBy
 * @property string $modified
 * @property integer $modifiedBy
 * @property string $deleted
 * @property integer $deletedBy
 *
 * @property ActivityRoom[] $activityRooms
 * @property Satker $refSatker
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_room';
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
            [['ref_satker_id', 'capacity', 'owner', 'computer', 'hostel', 'status', 'createdBy', 'modifiedBy', 'deletedBy'], 'integer'],
            [['code', 'name'], 'required'],
            [['created', 'modified', 'deleted'], 'safe'],
            [['code'], 'string', 'max' => 25],
            [['name', 'address'], 'string', 'max' => 255],
            [['code'], 'unique']
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
            'code' => 'Code',
            'name' => 'Name',
            'capacity' => 'Capacity',
            'owner' => 'Owner',
            'computer' => 'Computer',
            'hostel' => 'Hostel',
            'address' => 'Address',
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
    public function getActivityRooms()
    {
        return $this->hasMany(ActivityRoom::className(), ['tb_room_id' => 'id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatker()
    {
        return $this->hasOne(Satker::className(), ['id' => 'ref_satker_id']);
    }
	/**
     * @inheritdoc
     * @return RoomQuery
     */
    public static function find()
    {
        return new RoomQuery(get_called_class());
    }
}

class RoomQuery extends \yii\db\ActiveQuery
{
    public function currentSatker()
    {
        $this->andWhere(['ref_satker_id'=>(int)Yii::$app->user->identity->employee->ref_satker_id]);
        return $this;
    }
	
	public function active($status=1)
    {
        $this->andWhere(['status'=>$status]);
        return $this;
    }
}
