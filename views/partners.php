<?php if( $partners->have_posts() ): ?>
<section class="partners">
    <!-- open .container -->
    <div class="container">
        <!-- open .row -->
        <div class="row">
            <!-- open .block_title -->
            <h2 class="block_title">НАШИ ПАРТНЁРЫ</h2>
            <!-- close .block_title -->
            <!-- open .block_desc -->
            <h5 class="block_desc">Список компаний, которые с нами сотрудничают</h5>
            <!-- close .block_desc -->
            <!-- open .col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-10 col-sm-12 xol-xs-12 -->
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-10 col-sm-12 xol-xs-12">
                <!-- open .row -->
                <div class="row">
                <?php while ($partners->have_posts()) : $partners->the_post(); ?>
                    <!-- open .partners__item -->
                    <div class="partners__item">
                        <?php the_post_thumbnail();?>
                    </div>
                    <!-- close .partners__item -->
                <?php endwhile ?>
                </div>
                <!-- close .row -->
            </div>
            <!-- close .col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-10 col-sm-12 xol-xs-12 -->
        </div>
        <!-- close .row -->
    </div>
    <!-- close .container -->
</section>
<?php endif ?>
<?php wp_reset_query(); ?>