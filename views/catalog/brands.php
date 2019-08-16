<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>


<div class="features_items"><!--<!--features_items-->
    <h2 class="title text-center">Бренды</h2>
        <?php if (!empty($brands)): ?>
        <div class="row">
    <?php foreach ($brands as $brand): ?>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="http://placehold.it/327x200/b0b0b0" alt="<?= Html::encode($brand['name']); ?>" />
                        <?//=
                        Html::img(
                        '@web/images/brands/'.$brand['image'],
                        ['alt' => $brand['name']]
                        );
                        ?>
                        <div class="caption">
                            <h2>
                                <a href="<?= Url::to(['catalog/brand', 'id' => $brand['id']]); ?>">
        <?= Html::encode($brand['name']); ?>
                                </a>
                            </h2>

                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
        </div>
<?php endif; ?>
</div>