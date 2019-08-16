<?php
/*
 * Файл components/views/brands.php
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="brands-name">
    <ul nav nav-pills nav-stacked>
<?php foreach ($brands as $brand): ?>
            <li>
                <a href="<?= Url::to(['catalog/brand', 'id' => $brand['id']]); ?>">
                    <span class="badge pull-right"><?= $brand['count']; ?></span>
    <?= Html::encode($brand['name']); ?>
                </a>
            </li>
<?php endforeach; ?>
    </ul>
</div>