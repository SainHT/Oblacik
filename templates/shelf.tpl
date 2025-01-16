{config_load file="db.conf" section="Database"}
{include file="header.tpl" title=foo}
{include file="navbar.tpl"}

{foreach $categories as $category => $items}
  {if $category !== $items}
  <h2>{$category|capitalize}</h2>
  <div class="shelf-container">
    <div id="shelf_slides">
      {foreach $items as $item}
        <div class="slide w3-display-container"><a href="index.php?page={$category}&id={$item.ID}">
            {if $item.thumbnail}
              <img src="/~{#user#}/oblacik/assets/img/thumbnails/{$item.thumbnail}" alt="{$item.name}">
            {else}
              <img src="{$default_img}" alt="{$item.name}">
            {/if}
            <div class="w3-padding thumbnail-overlay">
              <div class="thumbnail-text">
                  {$item.name}
              </div>
            </div>
        </a>
            {if $logged}
              <button class="fav" type="button" onclick="toggleFavourite(this, {$item.upload_ID})">
              <div>
                  <i id="heart-{$item.upload_ID}" class="heart fa fa-{if $item.upload_ID|in_array:$favourites}heart{else}heart-o{/if}"></i>
              </div>
              </button>
            {/if}
        </div>
      {/foreach}
    </div>
  </div>
  {/if}
{/foreach}

    
{include file="footer.tpl"}