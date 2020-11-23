<section id="news" class="main-container">
        <h1>News</h1>

        <?php if (isset($result)) { ?>
                <p class="message <?php $class_msg = $result['status'] === true ? "message--correct" : "message--error" ?><?= $class_msg ?>"><?= $result['message'] ?></p>
        <?php } ?>

        <div class="news">
                <?php foreach ($news as $news_item) : ?>

                        <div class="news__container">
                                <a class="news__link" href="<?php echo base_url('news/' . $news_item['slug']); ?>">
                                        <h3><?php echo $news_item['title']; ?></h3>
                                        <div class="main">
                                                <?php echo $news_item['text']; ?>
                                        </div>
                                </a>
                        </div>

                <?php endforeach; ?>
        </div>
</section>