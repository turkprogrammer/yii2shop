<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;

?>

<?php 
//echo \app\controllers\AppController::debug($category);
echo Breadcrumbs::widget([
    'itemTemplate' => "<li>{link}</li>\n", // template for all links
    'links' => [
        [
            'label' =>$category['name'],
            'url' => ['catalog/category', 'id' => $product['cats']],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
     
       $product['name'],
    ],
]);
?>


<h2 class="title text-center"><?= Html::encode($product['name']); ?></h2>
<div class="product-details"><!--product-details-->
     
    <div class="col-sm-5">
        <div class="view-product">
            <img src="http://placehold.it/327x378/b0b0b0" alt="" />
            <h3>ZOOM</h3>
        </div>
        <div id="similar-product" class="carousel slide" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                </div>
                <div class="item">
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                </div>
                <div class="item">
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                    <a href=""><img src="http://placehold.it/84x84/b0b0b0" alt=""></a>
                </div>

            </div>

            <!-- Controls -->
            <a class="left item-control" href="#similar-product" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right item-control" href="#similar-product" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>

    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="/images/product-details/new.jpg" class="newarrival" alt="" />
            <h2><?= $product['name']; ?></h2>
            <p>ID: <?= $product ['id']; ?></p>
            <img src="/images/product-details/rating.png" alt="" />
            <span>
                <span>US <?= $product['price'] ?> $ </span>
                <label>Quantity:</label>
                <input type="text" value="1" />
                <button type="button" class="btn btn-fefault cart">
                    <i class="fa fa-shopping-cart"></i>
                    Add to cart
                </button>
            </span>
            <p><b>Наличие:</b> In Stock</p>
            <p><b>Condition:</b> New</p>
            <p><b>Бренд:</b> <a class="" href="<?= \yii\helpers\Url::to(['catalog/brand', 'id' => $product['producer_id']]) ?>"><?= $brand['name'] ?></a></p>
            <a href=""><img src="/images/product-details/share.png" class="share img-responsive"  alt="" /></a>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Описание</a></li>
            <li ><a href="#companyprofile" data-toggle="tab">Другие продукты этого Бренда</a></li>


        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade" id="details" >
            <div class="col-sm-9">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-left">

                            <p><?= HtmlPurifier::process($product['name']); ?></p>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="tab-pane fade" id="companyprofile" >

            <?php if (!empty($similar)): ?>

                <?php foreach ($similar as $item): ?>
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="http://placehold.it/84x84/b0b0b0" alt="<?= Html::encode($item['name']); ?>" />
                                    <h2>$ <?= $item['price']; ?></h2>
                                    <p> <a href="<?= Url::to(['catalog/product', 'id' =>  $item['id']]) ?>"><?= Html::encode($item['name']); ?></a></p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>           
                <?php endforeach; ?>

            <?php endif; ?>

        </div>


    </div>
</div><!--/category-tab-->
