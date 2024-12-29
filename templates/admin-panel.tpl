{include file="header.tpl"}

<div class="login" style="width: 1500px;">
    <div class="form" style="max-width: 1500px;">
        {foreach from=$users item=user}
            <form method="POST" action="userUpdate.php">
                <input type="hidden" name="id" value="{$user['user_ID']}">
                <label for="username_{$user['user_ID']}">Username:</label>
                <input type="text" id="username_{$user['user_ID']}" name="username" value="{$user['name']}" style="width: auto;">
                <label for="password_{$user['user_ID']}">Password:</label>
                <input type="password" id="password_{$user['user_ID']}" name="password" style="width: auto;">
                <label for="email_{$user['user_ID']}">Email:</label>
                <input type="text" id="email_{$user['user_ID']}" name="email" value="{$user['email']}" style="width: auto;">
                <label for="privilege_{$user['user_ID']}">Privilege:</label>
                <input type="checkbox" id="privilege_{$user['user_ID']}" name="privilege" {if $user['privilege']}checked{/if} style="width: auto;">
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