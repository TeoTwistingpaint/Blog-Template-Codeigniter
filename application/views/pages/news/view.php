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

    <?php
    // Se l'utente è loggato, mostra il bottone di edit
    if ($this->session->userdata('logged_in')) {
    ?>
        <div class="edit-btn">
            <a href="<?= $edit_url ?>">Modifica news</a>
        </div>
    <?php }
    ?>
</section>