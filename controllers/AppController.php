<?php

namespace app\controllers;

class AppController extends \yii\web\Controller {

    public function debug($arr) {
        echo '<pre>' . print_r($arr, true) . '</pre>';
    }

    protected function setMeta($title = null, $keywords = null, $desc = null) {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => "$keywords"]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => "$desc"]);
    }

}
