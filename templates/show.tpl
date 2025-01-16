{config_load file="db.conf" section="Database"}
{include file="header.tpl"}
{include file="navbar.tpl" title=foo}

{if $file}
    <div style="min-height: 75vh;" class="w3-row">
      <div id="mediabox" style="padding: 10px; height:70vh;" class="w3-col s12 m12 l7">
        {if $file_type == 'video/mp4' || $file_type == 'video/webm' || $file_type == 'video/ogg'}
          <video id="media" controls style="width: 100%; height: 100%;">
            <source src="{$file.source_address}" type="{$file_type}">
            Your browser does not support the video tag.
          </video>
        {elseif $file_type == 'audio/mpeg' || $file_type == 'audio/ogg' || $file_type == 'audio/wav'}
          <audio id="media" controls style="width: 100%; height: 100%;">
            <source src="{$file.source_address}" type="{$file_type}">
            Your browser does not support the audio tag.
          </audio>
        {elseif $file_type == 'application/pdf'}
          <embed src="{$file.source_address}" type="application/pdf" width="100%" height="100%" />
        {else}
          <img src="{$file.source_address}" alt="{$file.name}" id="media" style="width: 100%; height: 100%;">
        {/if}
      </div>

      <div id="media_accesories" style="padding: 10px;" class="w3-col s12 m12 l5">
        <h3>{$file.name}</h3><br>
        <p1>Content</p1>
        <p>{$file.description}</p>
        <div id="button_wrapper">
          <a style="width: 80%" href="{$file.source_address}" download>
            <div id="download_butt">DOWNLOAD</div>
          </a>
          {if $logged}
            <button class="fav" type="button" onclick="toggleFavourite(this, {$file.upload_ID})">
            <div>
                <i id="heart-{$file.upload_ID}" class="heart fa fa-{if $file.upload_ID|in_array:$favourites}heart{else}heart-o{/if}"></i>
            </div>
            </button>
          {/if}
        </div>
      </div>
    </div>
{/if}
{include file="footer.tpl"}