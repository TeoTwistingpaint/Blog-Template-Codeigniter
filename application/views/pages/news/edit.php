<section id="edit-news" class="main-container">
    <div class="create-box">
        <h1>Modifica News:</h1>

        <?php echo validation_errors(); ?>
        <?php if (isset($error)) {
            echo (string)$error;
        } ?>

        <?php if (isset($result)) { ?>
            <p class="message <?php $class_msg = $result['status'] === true ? "message--correct" : "message--error" ?><?= $class_msg ?>"><?= $result['message'] ?></p>
        <?php } ?>

        <?php echo form_open_multipart("news/edit?news_slug={$news_item['slug']}"); ?>

        <label for="title">Title</label>
        <input type="input" name="title" value="<?= $news_item['title'] ?>" />

        <label for="text">Text</label>
        <textarea name="text"><?= $news_item['text'] ?></textarea>

        <!-- <?php if ($news_item['image'] == "") { ?>
            <label class="file">
                <input type="file" name='news_image' size='20' id="file" aria-label="File browser example">
                <span class="file-custom"></span>
            </label>
        <?php } else { ?>
            <a class="remove-img" href="news/remove">Rimuovi immagine</a>
        <?php } ?> -->

        <div class="btn-container">
            <input class="form-submit" type="submit" name="submit" value="Aggiorna news" />
        </div>

        </form>
    </div>

    <a class="logout" href="/login/logout">Logout</a>
</section>