<ul class="pc-navbar__menu menu-desktop menubar-navigation " role="menubar">

    {foreach from=$menu_elements item=row}
        {if $row['childs']}
            <li role="none">
                <a role="menuitem" aria-haspopup="true" aria-expanded="false" href="{$row['url']}">
                    {$row['title']}
                    <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.75 0.750008L5.25 4.75001L9.75 0.750008" stroke="black" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>

                </a>

                <ul id="menu-element-{$row['id']}" class="menu-desktop__submenu" role="menu" aria-label="{$row['title']}">
                    {foreach from=$row['childs'] item=child}

                        <li class="submenu-column {if $child['submenu_type'] == 'large'}{$child['submenu_type']}{/if} {$child['column_width']} {if $child['hook']}hook-in-menu{/if}{$child['class']}"
                            role="none">
                            <a role="menuitem" class="submenu-column--title" href="{$child['url']}">{$child["submenu_title"]}</a>

                            {if $child['hook']}
                                {hook h="{$child['hook']}"}
                            {else}

                                <ul class="submenu-column__wrapper {$child['class']}">
                                    {foreach from=$child['childs'] item=child2}
                                        <li class="submenu-column--item {$child2['class']}">
                                            <a role="menuitem" href="{$child2['url']}">
                                                {$child2["title"]}
                                            </a>
                                        </li>
                                    {/foreach}
                                </ul>
                            {/if}

                        </li>
                    {/foreach}
                </ul>
            </li>

        {else}
            <li role="none">
                <a id="menu-element-{$row['id']}" class="menu-desktop__single-link {$row['class']}" role="menuitem"
                    href="{$row['url']}">{$row['title']}</a>
            </li>
        {/if}
    {/foreach}
</ul>