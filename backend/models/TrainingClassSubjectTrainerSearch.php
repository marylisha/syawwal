<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TrainingClassSubjectTrainer;

/**
 * TrainingClassSubjectTrainerSearch represents the model behind the search form about `backend\models\TrainingClassSubjectTrainer`.
 */
class TrainingClassSubjectTrainerSearch extends TrainingClassSubjectTrainer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tb_training_class_subject_id', 'tb_trainer_id', 'ref_trainer_type', 'cost', 'status', 'createdBy', 'modifiedBy', 'deletedBy'], 'integer'],
            [['created', 'modified', 'deleted'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TrainingClassSubjectTrainer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tb_training_class_subject_id' => $this->tb_training_class_subject_id,
            'tb_trainer_id' => $this->tb_trainer_id,
            'ref_trainer_type' => $this->ref_trainer_type,
            'cost' => $this->cost,
            'status' => $this->status,
            'created' => $this->created,
            'createdBy' => $this->createdBy,
            'modified' => $this->modified,
            'modifiedBy' => $this->modifiedBy,
            'deleted' => $this->deleted,
            'deletedBy' => $this->deletedBy,
        ]);

        return $dataProvider;
    }
}