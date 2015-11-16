<pre>
using namespace common\models

add item:           $item = Items::mk('description');// new item id is $item->id
del item:           Items::rm(1);
get all childs:     Items::findOne(1)->getAllChilds();
get all parents:    Items::findOne(1)->getAllParents();
is item has parents Items::findOne(6)->isHasParents([1,3,4]);

add link:           $link = Links::mk(6,8);
del link:           Links::rm(6,10);
swap links order:	Links::swapOrder(1,4,3);
</pre>