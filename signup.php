<article id="signup">
    <h2 class="major">Sign Up</h2>
    <!-- Toast -->
    <div class="toast-container toast">
        <span class="toast-message"></span>
        <div class="toast-progress"></div>
    </div>
    <form method="post" action="">
        <div class="fields">
            <div class="field half">
                <label><strong>Email</strong></label>
                <input type="email" name="username" maxlength="50" placeholder="Email" required/>
            </div>
            <div class="field half">
                <label><strong>Password</strong></label>
                <input type="password" name="password" minlength="6" placeholder="******" required/>
            </div>
        </div>
        <ul class="actions">
            <li><input type="submit" name="signup" value="Sign up" class="primary"/></li>
            <li><input type="reset" value="Reset"/></li>
        </ul>
    </form>
    Already have an account? <a href="#signin"><b>Login here</b></a>
</article>