<div class="header-top__block header-top__block--cart col flex-grow-0">
    <div class="js-blockcart blockcart cart-preview dropdown" data-refresh-url="{$refresh_url}">
        <a href="#" role="button" id="cartDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="header-top__link d-lg-flex d-none align-items-center"
            aria-label="{l s='Cart' d='Shop.Navigation'} ({$cart.products_count}, {$cart.totals.total.value})">
            <div class="header-top__icon-container">
                <img src="{$urls.theme_assets}img/header/cart.png" alt="" aria-hidden="true">

                <span class="header-top__badge {if $cart.products_count > 9}header-top__badge--smaller{/if}"
                    aria-hidden="true">
                    {$cart.products_count}
                </span>
            </div>

            <span class="header-top__cart-total d-none d-lg-inline">
                {$cart.totals.total.value}
            </span>
        </a>

        <a href="{$cart_url}" class="d-flex d-lg-none header-top__link">
            <div class="header-top__icon-container">
                <img src="{$urls.theme_assets}img/header/cart.png" alt="" aria-hidden="true">
                <span class="header-top__badge {if $cart.products_count > 9}header-top__badge--smaller{/if}">
                    {$cart.products_count}
                </span>
            </div>
        </a>
        <div class="dropdown-menu blockcart__dropdown cart-dropdown dropdown-menu-right" aria-labelledby="cartDropdown">
            <div class="cart-dropdown__content keep-open js-cart__card-body cart__card-body">
                <div class="cart-loader">
                    <div class="spinner-border text-primary" role="status"><span
                            class="sr-only">{l s='Loading...' d='Shop.Theme.Global'}</span></div>
                </div>
                <div class="cart-dropdown__title d-flex align-items-center mb-3">
                    <p class="h5 mb-0 mr-2">
                        {l s='Your cart' d='Modules.Isshoppingcart.Isshoppingcart'}
                    </p>
                    <a data-toggle="dropdown" href="#"
                        class="cart-dropdown__close dropdown-close ml-auto cursor-pointer text-decoration-none">
                        <i class="material-icons d-block">close</i>
                    </a>
                </div>
                {if $cart.products_count > 0}
                    <div class="cart-dropdown__products pt-3 mb-3">
                        {foreach from=$cart.products item=product}
                            {include 'module:is_shoppingcart/views/templates/front/is_shoppingcart-product-line.tpl' product=$product}
                        {/foreach}
                    </div>

                    <div class="cart-summary-line cart-total">
                        <span class="label">{$cart.totals.total.label}</span>
                        <span class="value">{$cart.totals.total.value}</span>
                    </div>

                    <div class="mt-3">
                        <a href="{$cart_url}" class="btn btn-sm btn-primary btn-block dropdown-close">
                            {l s='Proceed to checkout' d='Shop.Theme.Actions'}
                        </a>
                    </div>

                {else}
                    <div class="alert alert-warning">
                        {l s='Unfortunately your basket is empty' d='Modules.Isshoppingcart.Isshoppingcart'}
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>