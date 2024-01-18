<?php

namespace frontend\components;

use common\models\Category;
use yii\base\Widget;

class MenuWidget extends Widget
{
    public $tpl;
    public $data; // database dagi xamma qategorylar
    public $tree;
    public $menuHtml;


    public function init()
    {
        parent::init(); // avlod class ichida ajdod clasi constructorini chaqishish
        if ($this->tpl === null) {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run()
    {
        // get cache
        $menu = \Yii::$app->cache->get('menu'); // agar cache hotirada malumotlar bolsa shu joydan oladi 
        if ($menu) return $menu;

        $this->data = Category::find()->indexBy('id')->asArray()->all(); // indexBy([] va id raqamlarini birxil qiladi), asArray(faqat [] korinishida chiqaradi)
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
//        debug($this->tree);
        
        // set cache
        \Yii::$app->cache->set('menu', $this->menuHtml, 5); // cache xotirada malumotlarni yaratadi, 5 xotirada malumotlar yangilarish vaqti (secunds)
        
        return $this->menuHtml;
    }

    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id => & $node) {
            if (!$node['parent_id'])
                $tree[$id] = & $node;
            else
                $this->data[$node['parent_id']]['children'][$node['id']] = & $node;
        }
        return $tree;
    }

    protected function getMenuHtml($tree)
    {
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category);
        }
        return $str;
    }

    protected function catToTemplate($category)
    {
        ob_start();
        include __DIR__ . '/menu-tpl/' . $this->tpl;
        return ob_get_clean();
    }
}
