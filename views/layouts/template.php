<?= $this->render('_header'); ?>
<!--slider-->
<?= $this->render('_slider'); ?>
<!--/slider-->
   <section id="advertisement">
		<div class="container">
			<img src="/images/shop/advertisement.jpg" alt="" />
		</div>
	</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <!-- Leftsidebar -->
                <?= $this->render('_leftsidebar'); ?>
                <!-- Leftsidebar -->
            </div>

            <div class="col-sm-9 padding-right">             
                <?= $content ?>
            </div>


        </div>
    </div>
</div>
</section>
<!--Footer-->
<?= $this->render('_footer'); ?>