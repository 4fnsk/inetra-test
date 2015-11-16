<?php

namespace common\models;

use Yii;

class Links extends ARLinks
{
    /**
     * Sets the next order property.
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->to === $this->from) {
            return false;
        }
        if ($this->isNewRecord)
        {
            $lastId = self::find()
                ->where(['from' => $this->from])
                ->max('"order"');
            $this->order = ++$lastId;
        }
        return parent::beforeValidate();
    }


    /**
     * Creates new link between nodes.
     * @param int $from
     * @param int $to
     * @return Links
     */
    public static function mk($from, $to)
    {
        $link = new self();
        $link->from = $from;
        $link->to = $to;
        $link->save();
        return $link;
    }


    /**
     * Deletes link between nodes.
     * @param int $from
     * @param int $to
     */
    public static function rm($from, $to)
    {
        $link = self::findOne(['"from"' => $from, '"to"' => $to]);
        if ($link !== null) {
            $link->delete();
        }
    }


    /**
     * Swaps childs order between each other.
     * @param int $from Parent node
     * @param int $to1 the 1st child node
     * @param int $to2 the 2nd child node
     * @return bool
     */
    public static function swapOrder($from, $to1, $to2)
    {
        $link1 = self::findOne(['"from"' => $from, '"to"' => $to1]);
        $link2 = self::findOne(['"from"' => $from, '"to"' => $to2]);
        if ($link1 !== null && $link2 !== null) {

            $transaction = Yii::$app->db->beginTransaction();

            $ln1Order = $link1->order;
            $link1->order = $link2->order;
            $link2->order = $ln1Order;

            if ($link1->save() && $link2->save()) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
                return false;
            }
        }
        return false;
    }

}
