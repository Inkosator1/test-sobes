<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * OrderSearch
 */
class OrderSearch  extends Order
{
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = self::find();

        $query->with(["quantity", "user_id", "created_at"]);

        return $this->getDataProvider($query, $params);
    }

    public function restSearch($params): ActiveDataProvider
    {
        $query = self::find();

        $query->select(
            [
                'id',
                'user_id',
                'product',
                'quantity',
                'created_at',
            ]
        );

        return $this->getDataProvider($query, $params, '');
    }

    /**
     * Метод возвращает Data provider из переданного запроса и поиска на основе params
     *
     * @param ActiveQuery $query
     * @param $params
     * @param string|null $formName
     *
     * @return ActiveDataProvider
     */
    private function getDataProvider(ActiveQuery $query, $params, string $formName = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 100),
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params, $formName) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}