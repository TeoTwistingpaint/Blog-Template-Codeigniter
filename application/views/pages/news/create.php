<section id="create-news" class="main-container">
    <div class="create-box">
        <h1><?php echo $title; ?></h1>

        <?php echo validation_errors(); ?>
        <?php if (isset($error)) {
            echo (string)$error;
        } ?>

        <?php echo form_open_multipart('news/create'); ?>

        <label for="title">Titolo</label>
        <input type="input" name="title" />

        <label for="text">Testo</label>
        <textarea name="text"></textarea>

        <label class="file">
            <input type="file" name='news_image' size='20' id="file" aria-label="File browser example">
            <span class="file-custom"></span>
        </label>

        <div class="btn-container">
            <input class="form-submit" type="submit" name="submit" value="Crea" />
        </div>

        </form>
    </div>

    <div class="logout-container">
        <a class="logout" href="/login/logout">Logout</a>
    </div>
</section>