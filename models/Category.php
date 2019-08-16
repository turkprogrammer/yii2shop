<?php

namespace app\models;

use yii\data\Pagination;
use yii\db\ActiveRecord;
use Yii;

class Category extends ActiveRecord {

    /**
     * Возвращает имя таблицы БД
     */
    public static function tableName() {
        return 'cat';
    }

    /**
     * Возвращает товары категории
     */
    public function getProducts() {
        // связь таблицы БД `category` с таблицей `product`
        return $this->hasMany(Product::class, ['cats' => 'id']);
    }

    /*
     * Метод возвращает информацию о категории с идентификатором $id
     */

    public function getCategory($id) {
        return self::findOne($id);
    }

    /**
     * Возвращает родительскую категорию
     */
    public function getParent() {
        // связь таблицы БД `category` с таблицей `category`
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * Возвращает дочерние категории
     */
    public function getChildren() {
        // связь таблицы БД `category` с таблицей `category`
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * Возвращает массив товаров в категории с идентификатором $id и во
     * всех ее потомках, т.е. в дочерних, дочерних-дочерних и так далее
     */
    public function getCategoryProducts($id) {
       
        $id = (int) $id;
        // получаем массив идентификаторов всех потомков категории
        $ids = $this->getAllChildIds($id);
        $ids[] = $id;
        // для постаничной навигации получаем только часть товаров
        $query = Product::find()->where(['in', 'cats', $ids]);
        //\app\controllers\AppController::debug($pages->limit);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' =>  Yii::$app->params['pageSize'],//
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
      
//\app\controllers\AppController::debug($pages);
        $products = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->asArray()
                ->all();
        return [$products, $pages];
    }

    /**
     * Возвращает массив идентификаторов всех потомков категории $id,
     * т.е. дочерние, дочерние дочерних и так далее
     */
    protected function getAllChildIds($id) {
        $children = [];
        $ids = $this->getChildIds($id);
        foreach ($ids as $item) {
            $children[] = $item;
            $c = $this->getAllChildIds($item);
            foreach ($c as $v) {
                $children[] = $v;
            }
        }
        return $children;
    }

    /**
     * Возвращает массив идентификаторов дочерних категорий (прямых
     * потомков) категории с уникальным идентификатором $id
     */
    protected function getChildIds($id) {
        $children = self::find()->where(['parent_id' => $id])->asArray()->all();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child['id'];
        }
        return $ids;
    }

}
