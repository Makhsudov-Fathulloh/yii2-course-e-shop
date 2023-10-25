<?php

namespace common\components;
class AppController extends \yii\web\Controller
{
    protected function setMeta($title = null, $keywords = null, $description = null) {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'keywords']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'description']);
    }
}