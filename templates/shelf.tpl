{config_load file="db.conf" section="AdminPanel"}
{include file="header.tpl" title=foo}

<div id="navbar">
    <a href="index.php">Home</a>
    {foreach from=$categories key=key item=value}
      <a href="#{$key}">{$key|capitalize}</a>
    {/foreach}
    <input type="text" placeholder="Search..">
</div>

<div class="shelf-container">
    <div class="slides">
      {foreach $items as $item}
        <div class="slide"><a href="index.php?page={$category}&id={$item.ID}">
          <img src="https://img.freepik.com/premium-photo/purple-background-with-purple-background-that-says-purple_517312-43531.jpg" alt="{$item.name}">
        </a></div>  {* src="{$item.cover}" - add when thumbnails are done*}
      {/foreach}
    </div>

    
{include file="footer.tpl"}