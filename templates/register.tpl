{include file="header.tpl"}

<div class="login">
    <div class="form">
        <form action="register.php" method="post">
            <input type="text"     name="username" placeholder="username" id="username" 
            minlength="4" pattern="[a-zA-Z0-9]+" required/>
            <input type="password" name="password" placeholder="password" id="password" 
            minlength="8" required/>
            <input type="password" name="r_password" placeholder="confirm password" id="r_password"
            minlength="8" required/>
            <input type="email"    name="email"    placeholder="email"    id="email"
            pattern="^[\w.-]+@[\w.-]+\.[\w]+$" required/>
            
            <input type="submit" class="w3-button w3-purple" value="Create"/>
            <p class="message">Already registered? <a href="index.php?page=log">Sign In</a></p>
        </form>
    </div>
</div>

{include file="footer.tpl"}