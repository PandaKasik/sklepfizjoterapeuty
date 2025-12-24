<div class="menu-dialog">
    {foreach from=$menu_elements item=row}
        {if $row['highlighted']}
            <div class="menu-dialog__highlight menu-dialog__highlight--list">
                <a id="menu-mobile-item-{$row['id']}" href="{$row['url']}" target="{$row['target']}"
                    class="menu-dialog__highlight--item {$row['class']}">{$row['title']}</a>
            </div>
        {/if}
    {/foreach}

    <div class="menu-dialog__navigation" aria-label="Menu mobile">
        <div class="panda-accordion-list menu-dialog__navigation__accordions">
            {foreach from=$menu_elements item=row name=menu_elem}
                {if $row['childs']}
                    <div class="panda-accordion">
                        <h3 class="panda-accordion__heading">
                            <button id="menu-mobile-btn-{$row['id']}" class="panda-accordion__trigger {$row['class']}"
                                type="button" aria-expanded="false" aria-controls="menu-mobile-panel-{$row['id']}">
                                <span class="panda-accordion__trigger__text">
                                    {$row['title']}
                                    <span class="panda-accordion__trigger--icon"></span>
                                </span>
                            </button>
                        </h3>

                        <div class="panda-accordion__panel" id="menu-mobile-panel-{$row['id']}" role="region"
                            aria-labelledby="menu-mobile-btn-{$row['id']}">
                            <ul class="menu-dialog-submenu">
                                {foreach from=$row['childs'] item=child}

                                    <li class="menu-dialog-submenu__item">
                                        <a id="menu-mobile-item-{$child['id']}"
                                            class="menu-dialog-submenu__item--link single-link {$child['class']}"
                                            href="{$child['url']}" target="{$child['target']}">
                                            <span class="single-link--text">
                                                {$child['title']}
                                            </span>

                                           
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                {/if}
            {/foreach}
        </div>

        <div class="menu-dialog__navigation__single-links">
            {foreach from=$menu_elements item=row}
                {if $row['submenu'] == 0 && $row['icon_highlighted'] == 0 && $row['highlighted'] == 0 }
                    <a class="single-link {$row['class']}" href="{$row['url']}">
                        <span class="single-link--text">
                            {$row['title']}
                        </span>

                        {if $row['label_highlighted'] == 1 && $row['label_highlighted']}
                            <span class="single-link--label"
                                style="color:{$row['label_text_color']};background-color:{$row['label_color']};">{$row['label_text']}</span>
                        {/if}
                    </a>
                {/if}
            {/foreach}
        </div>
    </div>

   
</div>