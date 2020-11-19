<section id="news" class="main-container">
        <h1>News</h1>

        <div class="news">
                <?php foreach ($news as $news_item) : ?>

                        <div class="news__container">
                                <h3><?php echo $news_item['title']; ?></h3>
                                <div class="main">
                                        <?php echo $news_item['text']; ?>
                                </div>
                                <a class="news__link" href="<?php echo base_url('news/' . $news_item['slug']); ?>">View article</a>
                        </div>

                <?php endforeach; ?>
        </div>
</section>