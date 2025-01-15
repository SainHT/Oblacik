{config_load file="db.conf" section="AdminPanel"}

<div id="navbar">
    <div id="navbarcomp">
        <a href="index.php">Home</a>
        {foreach $categories as $key => $value}
        <a href="index.php?page=shelf&type={$key}">{$key|capitalize}</a>
        {/foreach}

        {if $admin}
            <a href="admin.php" style="float: right;">Admin Panel</a>
        {/if}
        <input type="text" placeholder="Search..">
    </div>

    <div id="burger">
        <a href="javascript:void(0);" class="icon" onclick="toggleBurger()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>
        </a>
    </div>

    <div id="navbarmobile">
        <input type="text" placeholder="Search..">

        <a href="index.php">Home</a>
        {foreach $categories as $key => $value}
        <a href="#{$key}">{$key|capitalize}</a>
        {/foreach}

        {if $admin}
            <a href="admin.php">Admin Panel</a>
        {/if}
        
    </div>

</div>