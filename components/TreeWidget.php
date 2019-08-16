<?php

namespace app\components;

use yii\base\Widget;
use app\models\Category;
use app\models\Brand;
use Yii;

/**
 * Виджет для вывода дерева разделов каталога товаров
 */
class TreeWidget extends Widget {

    /**
     * Определяет внешний вид дерева категорий: меню (menu) или
     * список (list). Меню используется как в публичной, так и в
     * административной части, для навигации по каталогу товаров.
     * Список используется в панели управления при редактировании
     * товара или раздела каталога, чтобы иметь возможность выбрать
     * родительскую категорию.
     */
    public $template;

    /**
     * Выборка категорий каталога из базы данных
     */
    protected $data;

    /**
     * Массив категорий каталога в виде дерева
     */
    protected $tree;

    public function init() {
        parent::init();
        if ($this->template === null) {
            $this->template = 'menu';
        }
    }

    public function run() {
        
        // пробуем извлечь данные из кеша
        $html = Yii::$app->cache->get('catalog-menu');
        if ($html === false) {
            // данных нет в кеше, получаем их заново
            $this->data = Category::find()->indexBy('id')->asArray()->all();
            //print_r($this->data);
            $this->makeTree();
            if (!empty($this->tree)) {
                $html = $this->render($this->template, ['tree' => $this->tree]);
            } else {
                $html = '';
            }
            //////////////////////////////////////////////////////
            
       
         ///////////////////////////////////////////////////
          
            // сохраняем полученные данные в кеше
            Yii::$app->cache->set('catalog-menu', $html, 60);
        }
        return $html;
    }

    /**
     * Функция принимает на вход  массив элеменов, связанных
     * отношениями parent-child, и возвращает массив в виде дерева
     */
    protected function makeTree() {
        if (empty($this->data)) {
            return;
        }
        foreach ($this->data as $id => &$node) {
            if (!$node['parent_id']) {
                $this->tree[$id] = &$node;
            } else {
                $this->data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
    }

}
