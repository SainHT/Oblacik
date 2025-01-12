{config_load file="db.conf" section="AdminPanel"}
{include file="header.tpl" title=foo}

<div id="navbar">
    <a href="index.php">Home</a>
    {foreach $categories as $key => $value}
      <a href="#{$key}">{$key|capitalize}</a>
    {/foreach}
    <input type="text" placeholder="Search..">

    {if $admin}
      <a href="index.php?{#admin#}={#getter#}" style="float: right;">Admin Panel</a>
    {/if}
</div>

<p>This site will grow as we add more ...</p>
</div>

{foreach $categories as $category => $items}
  <h2>{$category|capitalize}</h2>
  <div class="slideshow-container">
    <div class="slides">
      {foreach $items as $item}
        <div class="slide"><a href="index.php?page={$category}&id={$item.ID}">
          <img src="https://img.freepik.com/premium-photo/purple-background-with-purple-background-that-says-purple_517312-43531.jpg" alt="{$item.name}">
        </a></div>  {* src="{$item.cover}" - add when thumbnails are done*}
      {/foreach}
    </div>
  </div>
{/foreach}

{include file="footer.tpl"}
