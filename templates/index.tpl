{config_load file="db.conf" section="Database"}
{include file="header.tpl" title=foo}
{include file="navbar.tpl"}

{if $fav_bar}
  <h2>Favourites</h2>
  <div class="slideshow-container">
    <div class="slides">
      {foreach $fav_bar as $item}
        <div class="slide w3-display-container"><a href="index.php?page={$item.type}&id={$item.ID}">
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
                    <i id="heart-{$item.upload_ID}" class="heart fa fa-heart"></i>
                </div>
                </button>
            {/if}
        </div>
      {/foreach}
    </div>
  </div>
{/if}

{foreach $categories as $category => $items}
  <h2>{$category|capitalize}</h2>
  <div class="slideshow-container">
    <div class="slides">
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
{/foreach}

{include file="footer.tpl"}
