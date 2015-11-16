<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property integer $from
 * @property integer $to
 * @property integer $order
 *
 * @property Items $from0
 * @property Items $to0
 */
class ARLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to', 'order'], 'required'],
            [['from', 'to', 'order'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'from' => 'From',
            'to' => 'To',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom0()
    {
        return $this->hasOne(Items::className(), ['id' => 'from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo0()
    {
        return $this->hasOne(Items::className(), ['id' => 'to']);
    }
}
