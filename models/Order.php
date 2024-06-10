<?php

namespace app\models;

use Cassandra\Date;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 */
class Order extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'quantity', 'product', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'product' => 'Названия продукта',
            'created_at' => 'Дата создания',
            'quantity' => 'Количество',
        ];
    }

    /**
     * Возвращает ошибки валидации в строке
     *
     * @return string|null
     */
    public function getReadableErrors(): ?string
    {
        $error_message = '';

        if (!empty($this->errors)) {
            foreach ($this->errors as $attribute => $error) {
                $error_message .= $attribute . ': ' . implode(', ', $error) . ' ';
            }
            return $error_message;
        }
        return null;
    }
}