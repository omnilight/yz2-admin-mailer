<?php

namespace yz\admin\mailer\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yz\admin\mailer\common\models\Mail;

/**
 * MailSearch represents the model behind the search form about `yz\admin\mailer\common\models\Mail`.
 */
class MailSearch extends Mail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['status', 'receivers_provider', 'receivers_provider_data', 'from', 'from_name', 'subject', 'body_html', 'boxy_text', 'created_at'], 'safe'],
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
        $query = Mail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'receivers_provider', $this->receivers_provider])
            ->andFilterWhere(['like', 'receivers_provider_data', $this->receivers_provider_data])
            ->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'from_name', $this->from_name])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body_html', $this->body_html])
            ->andFilterWhere(['like', 'boxy_text', $this->boxy_text])
            ->andFilterWhere(['between', 'created_at', Yii::$app->formatter->asDate($this->created_at, 'YYYY-MM-d 00:00:00'), Yii::$app->formatter->asDate($this->created_at, 'YYYY-MM-d 23:59:59')]);

        return $dataProvider;
    }
}
