{config_load file="db.conf" section="Database"}
{include file="header.tpl" title=foo}
{include file="navbar.tpl"}

{foreach $categories as $category => $items}
  {if $category !== $items}
  <h2>{$category|capitalize}</h2>
  <div class="shelf-container">
    <div id="shelf_slides">
      {foreach $items as $item}
        <div class="slide"><a href="index.php?page={$category}&id={$item.ID}">
            {if $item.thumbnail}
              <img src="/~{#user#}/oblacik/assets/img/thumbnails/{$item.thumbnail}" alt="{$item.name}">
            {else}
              <img src="{$default_img}" alt="{$item.name}">
            {/if}
        </a>
            {if $logged}
              <button class="fav" type="button" onclick="favourite({$item.upload_ID})">❤</button>
            {/if}
        </div>
      {/foreach}
    </div>
  </div>
  {/if}
{/foreach}

    
{include file="footer.tpl"}