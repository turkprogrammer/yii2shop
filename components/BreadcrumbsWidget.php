<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use app\models\Category;
use yii\base\Widget;
use Yii;

/**
 * Виджет для вывода цепочки навигации (хлебные крошки)
 */
class BreadCrumbsWidget extends Widget {

    /**
     * Идентификатор текущей категории
     */
    public $itemCurrent;

    /**
     * Показывать текущую категорию?
     */
    public $showCurrent = true;

    public function run() {
        if (empty($this->itemCurrent)) {
            return '';
        }
        // пробуем извлечь данные из кеша
        $show = $this->showCurrent ? 'true' : 'false';
        $key = 'widget-chain-'.$this->itemCurrent.'-show-'.$show;
        $html = Yii::$app->cache->get($key);
        if ($html === false) {
            // данных нет в кеше, получаем их заново
            $chain = (new Category())->getParents($this->itemCurrent);
            \app\controllers\AppController::debug($chain);
            if (!$this->showCurrent) {
                array_pop($chain);
            }
            $html = $this->render('crumbs', ['chain' => $chain]);
            // сохраняем полученные данные в кеше
            Yii::$app->cache->set($key, $html);
        }
        return $html;
    }

}