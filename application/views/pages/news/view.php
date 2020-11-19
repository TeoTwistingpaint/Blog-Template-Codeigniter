<section id="news-item" class="main-container">
    <?php
    echo '<h1>' . $news_item['title'] . '</h1>';
    echo '<p>' . $news_item['text'] . '</p>';

    if (isset($news_item['image']) && $news_item['image'] != "") {
    ?>
        <img src="<?php echo base_url('/upload/') . $news_item['image'] ?>" />
    <?php
    }
    ?>
</section>