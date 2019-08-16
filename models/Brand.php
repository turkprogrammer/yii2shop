<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\Pagination;
use Yii;

class Brand extends ActiveRecord {

    /**
     * Метод возвращает имя таблицы БД
     */
    public static function tableName() {
        return 'producer';
    }

    /**
     * Метод возвращает массив товаров бренда
     */
    public function getProducts() {
        // связь таблицы БД `producer` с таблицей `product`
        return $this->hasMany(Product::class, ['producer_id' => 'id']);
    }

    /**
     * Возвращает информацию о бренде с идентификатором $id
     */
    public function getBrand($id) {
        $id = (int) $id;
        return self::findOne($id);
    }

  
    /**
     * Возвращает массив всех брендов каталога и
     * количество товаров для каждого бренда
     */
    public function getAllBrands() {
        $query = self::find();
        $brands = $query
                ->select([
                    'id' => 'producer.id',
                    'name' => 'producer.name',
                    'count' => 'COUNT(*)'
                ])
                ->innerJoin(
                        'product', 'product.producer_id = producer.id'
                )
                ->groupBy([
                    'producer.id', 'producer.name'
                ])
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all();
        return $brands;
    }

    /**
     * Возвращает массив популярных брендов и
     * количество товаров для каждого бренда
     */
    public function getPopularBrands() {
        // получаем бренды с наибольшим кол-вом товаров
        $brands = self::find()
                ->select([
                    'id' => 'producer.id',
                    'name' => 'producer.name',
                    'count' => 'COUNT(*)'
                ])
                ->innerJoin(
                        'product', 'product.producer_id = producer.id'
                )
                ->groupBy([
                    'producer.id', 'producer.name'
                ])
                ->orderBy(['count' => SORT_DESC])
                ->limit(10)
                ->asArray()
                // для дальнейшей сортировки
                ->indexBy('name')
                ->all();
        // теперь нужно отсортировать бренды по названию
        ksort($brands);
        return $brands;
    }

    /**
     * Возвращает массив всех товаров бренда с идентификатором $id
     */
    public function getBrandProducts($id) {
       // return Product::find()->where(['producer_id' => $id])->asArray()->all();
           $id = (int)$id;
        // для постаничной навигации получаем только часть товаров
        $query = Product::find()->where(['producer_id' => $id]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            // количество товаров на странице теперь в настройках
            'pageSize' => Yii::$app->params['pageSize'],
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return [$products, $pages];
    }
      
   
 

}
