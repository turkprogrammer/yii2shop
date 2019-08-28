<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\data\Pagination;

class Product extends ActiveRecord {

    /**
     * Возвращает имя таблицы БД
     */
    public static function tableName() {
        return 'product';
    }

    /**
     * Возвращает родительскую категорию
     */
    public function getCategory() {
        // связь таблицы БД `product` с таблицей `category`
        return $this->hasOne(Category::class, ['id' => 'cats']);
    }

    /**
     * Возвращает информацию о товаре с иденификатором $id
     */
    public function getProduct($id) {
       return self::find()->where(['id' => $id])->asArray()->one();
        //return self::find()->with('cats')->where(['id' => $id])->asArray()->one();
    }

    /**
     * Результаты поиска по каталогу товаров
     */
    public function getSearchResult($search, $page) {
        $search = $this->cleanSearchString($search);
        if (empty($search)) {
            return [null, null];
        }

        // пробуем извлечь данные из кеша
        $key = 'search-' . md5($search) . '-page-' . $page;
        $data = Yii::$app->cache->get($key);

        if ($data === false) { // данных нет в кеше, получаем их заново
            // разбиваем поисковый запрос на отдельные слова
            $words = explode(' ', $search);
            $query = self::find()->where(['like', 'name', $words[0]]);
            for ($i = 1; $i < count($words); $i++) {
                // формируем один из двух вариантов запроса — используя andWhere() или orWhere()в первом случае,
                //чтобы товар попал в выборку, нужно, чтобы он содержал в названии все три слова,
                // во втором случае — хотя бы одно слово

                $query = $query->andWhere(['like', 'name', $words[$i]]);
                // $query = $query->orWhere(['like', 'name', $words[$i]]);
            }
            // постраничная навигация
            $pages = new Pagination([
                'totalCount' => $query->count(),
                'pageSize' => Yii::$app->params['pageSize'],
                'forcePageParam' => false,
                'pageSizeParam' => false
            ]);
            $products = $query
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->asArray()
                    ->all();
            // сохраняем полученные данные в кеше
            $data = [$products, $pages];
            Yii::$app->cache->set($key, $data);
        }

        return $data;
    }

    /**
     * Вспомогательная функция, очищает строку поискового запроса с сайта
     * от всякого мусора
     */
    protected function cleanSearchString($search) {
        $search = iconv_substr($search, 0, 64);
        // удаляем все, кроме букв и цифр
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ]#u', ' ', $search);
        // сжимаем двойные пробелы
        $search = preg_replace('#\s+#u', ' ', $search);
        $search = trim($search);
        return $search;
    }

}
