<section id="login" class="main-container">
    <div class="login-box">
        <h1>Login</h1>
        <fieldset>
            <?php echo validation_errors(); ?>
            <?php echo form_open('login/dologin'); ?>
            <div class="user-box">
                <label for="username">User</label>
                <input type="text" name="username" value="" />
            </div>
            <div class="user-box">
                <label for="password">Password</label>
                <input type="password" name="password" value="" />
            </div>
            <div class="btn-container">
                <input class="form-submit" type="submit" value="Login" name="submit" />
            </div>
            </form>
        </fieldset>
    </div>
</section>