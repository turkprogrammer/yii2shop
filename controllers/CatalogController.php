<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use app\models\Brand;
use Yii;

class CatalogController extends AppController {

    public function actionIndex() {
        return $this->goHome();
    }

    /**
     * Категория каталога товаров
     */
    public function actionCategory($id) {

        $id = (int) $id;
        $temp = new Category();
        // товары категории
        list($products, $pages) = $temp->getCategoryProducts($id);

        $category = $temp->getCategory($id);
        if (empty($category)) {
            throw new \yii\web\HttpException(404, 'Такой категории не существует!');
        }

        $this->setMeta($category['name']);
        return $this->render(
                        'category', compact('category', 'products', 'pages')
        );
       
    }

    /**
     * Список всех брендов каталога товаров
     */
    public function actionBrands() {
            
        // пробуем извлечь данные из кеша
        $brands = Yii::$app->cache->get('all-brands');
        if ($brands === false) {
            // данных нет в кеше, получаем их заново
            $brands = (new Brand())->getAllBrands();
            // сохраняем полученные данные в кеше
            Yii::$app->cache->set('all-brands', $brands);        }
        $this->setMeta('Бренды');
        return $this->render(
            'brands',
            compact('brands')
        );
    }

    /**
     * Список товаров бренда с идентификатором $id
     */
    public function actionBrand($id) {        
        $id = (int)$id;
        $temp = new Brand();
        // товары бренда
        list($products, $pages) = $temp->getBrandProducts($id);
        // данные о бренде
        $brand = $temp->getBrand($id);
        if (empty($brand)) {
            throw new \yii\web\HttpException(404, 'Бренда не существует!');
        }
        // устанавливаем мета-теги
        $this->setMeta(
            $brand->name . ' | ' . Yii::$app->params['shopName']
          /*  $brand->keywords,
            $brand->description*/
        );
        return $this->render(
            'brand',
            compact('brand', 'products', 'pages')
        );
    }
    /**
     * Страница товара с идентификатором $id
     */
    public function actionProduct($id) {
        $id = (int)$id;
        // пробуем извлечь данные из кеша
        $data = Yii::$app->cache->get('product-'.$id);
        if ($data === false) {
            // данных нет в кеше, получаем их заново
            $product = (new Product())->getProduct($id);
            $brand = (new Brand())->getBrand($product['producer_id']);  
            $category = (new Category())->getCategory($product['cats']);
            
            //self::debug($category); ;
     
            $data = [$product, $brand];
            // сохраняем полученные данные в кеше
            Yii::$app->cache->set('product-'.$id, $data);
        }
        list($product, $brand) = $data;
        // устанавливаем мета-теги
        $this->setMeta(
            $product['name'] . ' | ' . Yii::$app->params['shopName']
        );
        // получаем  товары одного бренда, похожие на текущий
        $similar = Yii::$app->cache->get('similar-'.$product['id']);
        if ($similar === false) {
            // товары из той же категории того же бренда
            $similar = Product::find()
                ->where([
                   /* 'hit' => 1,*/
                    'cats' => $product['cats'],
                    'producer_id' => $product['producer_id']
                ])
                ->andWhere(['NOT IN', 'id', $product['id']])
                ->limit(3)
                ->asArray()
                ->all();
            Yii::$app->cache->set('similar-'.$product['id'], $similar);
        }
        return $this->render(
            'product',
            compact('product', 'brand', 'similar', 'category')
        );
    }
    
    /**
     * Результаты поиска по каталогу товаров
     */
    public function actionSearch($query = '', $page = 1) {

        $page = (int)$page;

        // получаем результаты поиска с постраничной навигацией
        list($products, $pages) = (new Product())->getSearchResult($query, $page);

        // устанавливаем мета-теги для страницы
        $this->setMeta('Поиск по каталогу');

        return $this->render(
            'search',
            compact('products', 'pages')
        );
    }
 

}
