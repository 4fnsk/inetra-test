<?php

namespace common\models;

use Yii;

class Items extends ARItems
{
    /**
     * Creates a node item.
     * @param string $desc. If null it ll be converted to random string
     * @return Items
     */
    public static function mk($desc = null)
    {
        $item = new self();
        if (!isset($desc)) {
            $desc = \Yii::$app->security->generateRandomString();
        }
        $item->desc =  (string)$desc;
        $item->save();
        return $item;
    }


    /**
     * Deletes a node item by id.
     * @param int $id.
     */
    public static function rm($id)
    {
        $item = self::findOne($id);
        if ($item !== null) {
            $item->delete();
        }
    }


    /**
     * Returns all childs->id recursive.
     * @return array
     */
    public function getAllChilds()
    {
        $childs = (object)[];
        $childs->set = [];

        foreach ($this->getOwnChilds($childs) as $child) {
            $child->getOwnChilds($childs);
        }
        return array_unique($childs->set);
    }


    /**
     * Returns own childs as array of AR-Items.
     * @param \stdClass $childs.
     * @return array
     */
    protected function getOwnChilds($childs)
    {
        $links = $this->getDownLinks()->all();
        $out = [];
        foreach ($links as $link) {
            $childs->set []= $link->to;
            $out []= Items::findOne($link->to);
        }
        return $out;
    }


    /**
     * Returns all parents->id recursive.
     * @return array
     */
    public function getAllParents()
    {
        $parents = (object)[];
        $parents->set = [];

        foreach ($this->getOwnParents($parents) as $parent) {
            $parent->getOwnParents($parents);
        }
        return array_unique($parents->set);
    }


    /**
     * Returns own parents as array of AR-Items.
     * @param \stdClass $parents.
     * @return array
     */
    protected function getOwnParents($parents)
    {
        $links = $this->getUpLinks()->all();
        $out = [];
        foreach ($links as $link) {
            $parents->set []= $link->from;
            $out []= Items::findOne($link->from);
        }
        return $out;
    }


    /**
     * Returns true if item has all of given nodes as parent, inverse - false.
     * @param array $parents.
     * @return bool
     */
    public function isHasParents($parents)
    {
        return (array_intersect($parents, $this->getAllParents()) == $parents);
    }
}
