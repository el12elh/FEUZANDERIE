<article id="signin">
    <h2 class="major">Sign In</h2>
    <!-- Toast -->
    <div class="toast-container toast">
        <span class="toast-message"></span>
        <div class="toast-progress"></div>
    </div>
    <form method="post" action="">
        <div class="fields">
            <div class="field half">
                <label><strong>Email</strong></label>
                <input type="email" name="username" value="" placeholder="Email" required/>
            </div>
            <div class="field half">
                <label><strong>Password</strong></label>
                <input type="password" name="password" minlength="6" placeholder="******" required/>
            </div>
        </div>
        <ul class="actions">
            <li><input type="submit" name="signin" value="Sign in" class="primary"/></li>
            <li><input type="reset" value="Reset"/></li>
        </ul>
    </form>
    New user? <a href="#signup"><b>Create an account</b></a><br/>
    Forgot password? <a href="#forgot_password"><b>Reset here</b></a>
</article>