{config_load file="db.conf" section="AdminPanel"}
{config_load file="db.conf" section="Database"}
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
            {if $item.thumbnail}
              <img src="/~{#user#}/oblacik/assets/img/thumbnails/{$item.thumbnail}" alt="{$item.name}">
            {else}
              <img src="{$default_img}" alt="{$item.name}">
            {/if}
        </a>
            <button class="fav" type="button" onclick="favourite({$item.upload_ID})">❤</button>
        </div>
      {/foreach}
    </div>
  </div>
{/foreach}

{include file="footer.tpl"}
