<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $desc
 *
 * @property Links[] $links
 * @property Links[] $links0
 */
class ARItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc'], 'required'],
            [['desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => 'Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDownLinks()
    {
        return $this->hasMany(Links::className(), ['from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpLinks()
    {
        return $this->hasMany(Links::className(), ['to' => 'id']);
    }
}
