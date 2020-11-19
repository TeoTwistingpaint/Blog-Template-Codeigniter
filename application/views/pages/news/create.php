<section id="create-news" class="main-container">
    <div class="create-box">
        <h1><?php echo $title; ?></h1>

        <?php echo validation_errors(); ?>
        <?php if (isset($error)) {
            echo (string)$error;
        } ?>

        <?php echo form_open_multipart('news/create'); ?>

        <label for="title">Title</label>
        <input type="input" name="title" />

        <label for="text">Text</label>
        <textarea name="text"></textarea>

        <?php //echo "<input type='file' name='news_image' size='20' />"; 
        ?>
        <label class="file">
            <input type="file" name='news_image' size='20' id="file" aria-label="File browser example">
            <span class="file-custom"></span>
        </label>

        <div class="btn-container">
            <input class="form-submit" type="submit" name="submit" value="Create news item" />
        </div>

        </form>
    </div>

    <a class="logout" href="/login/logout">Logout</a>
</section>