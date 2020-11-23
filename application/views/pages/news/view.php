<section id="news-item" class="main-container">
    <?php
    echo '<h1>' . $news_item['title'] . '</h1>';

    if (isset($news_item['image']) && $news_item['image'] != "") {
    ?>
        <img src="<?php echo base_url('/upload/') . $news_item['image'] ?>" />
    <?php
    }

    echo '<p>' . $news_item['text'] . '</p>';
    ?>

    <?php
    // Se l'utente è loggato, mostra il bottone di edit
    if ($this->session->userdata('logged_in')) {
    ?>
    <div class="admin-actions">
        <a class="btn btn--edit" href="<?= $edit_url ?>">Modifica news</a>
        <a class="btn btn--delete" href="/news/delete?news_slug=<?= $news_item['slug'] ?>">Elimina news</a>
    </div>
    <?php }
    ?>
</section>