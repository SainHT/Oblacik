{include file="header.tpl"}

<div id="navbar">
    <a href="index.php">Home</a>
    <a href="admin.php">Users</a>
    {foreach from=$categories key=key item=value}
        <a href="admin.php?page={$key}">{$key|capitalize}</a>
    {/foreach}
    <input type="text" placeholder="Search..">

</div>

<div class="login" style="width: 1500px;">
    <div class="form" style="max-width: 1500px;">
        {foreach $users as $user}
            <form method="POST" action="itemUpdate.php">
                {foreach $user as $key => $item}
                    {*make IDs hidden*}
                    {if $key == 'ID' || $key == 'upload_ID'}
                        <input type="hidden" name="{$key}" value="{$item}">
                        {continue}
                    {/if}

                    {*skip categories - not implemented*}
                    {if $key == 'category_ID'}
                        {continue}
                    {/if}

                    <label for="{$key}_{$user.ID}">{$key|capitalize}:</label>

                    {if $key == 'password'}
                        <input type="text" id="{$key}_{$user.ID}" name="{$key}" style="width: auto;">
                        {continue}
                    {/if}
                    {if $key == 'privilege'}
                        <input type="checkbox" id="{$key}_{$user.ID}" name="{$key}" {if $item}checked{/if} style="width: auto;">
                        {continue}
                    {/if}
                    
                    <input type="text" id="{$key}_{$user.ID}" name="{$key}" value="{$item}" style="width: auto;">
                {/foreach}
                <input type="submit" value="Update" style="width: auto;">
            </form>
        {/foreach}

        <div class="w3-center w3-bar">
            {if $current_page > 0}
                <a href="?page={$current_page-1}" class="w3-button">&laquo; Previous</a>
            {/if}

            {section name=page loop=$total_pages+1}
                {if $smarty.section.page.index == $current_page}
                    <span class="w3-button w3-gray">{$smarty.section.page.index + 1}</span>
                {else}
                    <a href="?page={$smarty.section.page.index}" class="w3-button">{$smarty.section.page.index + 1}</a>
                {/if}
            {/section}

            {if $current_page < $total_pages}
                <a href="?page={$current_page+1}" class="w3-button">Next &raquo;</a>
            {/if}
        </div>
    </div>
</div>

{include file="footer.tpl"}