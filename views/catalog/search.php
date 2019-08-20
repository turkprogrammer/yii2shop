<?php
/*
 * Страница результатов поиска по каталогу, файл views/catalog/search.php
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="features_items"><!--<!--features_items-->
    <h2 class="title text-center">Результаты поиска по каталогу:</h2>
    <?php if(!empty($products)) :?>
	<?php $i = 0 ;?>
    <?php foreach ($products as $product):?>
       <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img src="http://placehold.it/150x150/b0b0b0" alt="" />
                    <h2>$<?=$product['price']?></h2>                   
                    <h4><a class="" href="<?=Url::to(['catalog/product', 'id' => $product['id']]) ?>"><?= Html::encode($product['name']); ?></p></a></h4>
                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                </div>
                <!--   <div class="product-overlay">
                              <div class="overlay-content">
                                  <h2>$<?//= $product['price'] ?></h2>
                                  <p><a href="<?//= Url::to(['product/view', 'id' => $product->id]) ?>"><?//= $product['name'] ?></a></p>
                                  <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                              </div>
                          </div> -->
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                    <li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
                </ul>
            </div>
        </div>
    </div>
	
    <?php $i++ ;?>
    <?php if ($i % 3 ==0): ?>
    <div class="clearfix"></div>
    <?php endif;?>
    <?php endforeach; ?>
    <?php else : ?>
    <h3>Товары отсутствуют!</h3>
    <?php endif;?>
   
    <div class="clearfix"></div>
   <?= LinkPager::widget(['pagination' => $pages]); /* постраничная навигация */ ?>
            
</div><!--features_items-->