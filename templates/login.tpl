{include file="header.tpl"}

<div class="login">
    <div class="form">
        <form action="login.php" method="post">
            <input type="text"     name="username" placeholder="username" required/>
            <input type="password" name="password" placeholder="password" required/>

            <input type="submit" class="w3-button w3-green" value="Sign In"/>
            <p class="message">Not registered? <a href="index.php?page=reg">Create an account</a></p>
        </form>
    </div>
</div>

{include file="footer.tpl"}