<div class="header-top__block header-top__block--cart col flex-grow-0">
    <div class="js-blockcart blockcart cart-preview dropdown" data-refresh-url="{$refresh_url}">
        <a href="#" role="button" id="cartDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="header-top__link d-lg-flex d-none align-items-center"
            aria-label="{l s='Cart' d='Shop.Navigation'} ({$cart.products_count}, {$cart.totals.total.value})">
            <div class="header-top__icon-container">
                <svg width="34" height="33" viewBox="0 0 34 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.05664 7.16797H32.2259L29.0389 22.0938H7.50247L5.05664 7.16797Z" stroke="black"
                        stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M5.05721 7.16791L4.05853 1.07349H0" stroke="black" stroke-width="2.14676"
                        stroke-miterlimit="10" />
                    <path
                        d="M24.9409 26.6579H6.12046C4.94129 26.6579 3.93778 25.839 3.75578 24.7281C3.52899 23.3441 4.65137 22.0938 6.12046 22.0938H7.50233"
                        stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path
                        d="M24.9406 31.0735C26.2195 31.0735 27.2562 30.085 27.2562 28.8656C27.2562 27.6462 26.2195 26.6577 24.9406 26.6577C23.6617 26.6577 22.625 27.6462 22.625 28.8656C22.625 30.085 23.6617 31.0735 24.9406 31.0735Z"
                        stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path
                        d="M12.3429 31.0735C13.6218 31.0735 14.6585 30.085 14.6585 28.8656C14.6585 27.6462 13.6218 26.6577 12.3429 26.6577C11.0641 26.6577 10.0273 27.6462 10.0273 28.8656C10.0273 30.085 11.0641 31.0735 12.3429 31.0735Z"
                        stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M16.6074 10.7092V18.5521" stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M20.5234 10.7092V18.5521" stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M24.4414 10.7092V18.5521" stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M12.6895 10.7092V18.5521" stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                </svg>


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
                <svg width="34" height="33" viewBox="0 0 34 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.05664 7.16797H32.2259L29.0389 22.0938H7.50247L5.05664 7.16797Z" stroke="black"
                        stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M5.05721 7.16791L4.05853 1.07349H0" stroke="black" stroke-width="2.14676"
                        stroke-miterlimit="10" />
                    <path
                        d="M24.9409 26.6579H6.12046C4.94129 26.6579 3.93778 25.839 3.75578 24.7281C3.52899 23.3441 4.65137 22.0938 6.12046 22.0938H7.50233"
                        stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path
                        d="M24.9406 31.0735C26.2195 31.0735 27.2562 30.085 27.2562 28.8656C27.2562 27.6462 26.2195 26.6577 24.9406 26.6577C23.6617 26.6577 22.625 27.6462 22.625 28.8656C22.625 30.085 23.6617 31.0735 24.9406 31.0735Z"
                        stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path
                        d="M12.3429 31.0735C13.6218 31.0735 14.6585 30.085 14.6585 28.8656C14.6585 27.6462 13.6218 26.6577 12.3429 26.6577C11.0641 26.6577 10.0273 27.6462 10.0273 28.8656C10.0273 30.085 11.0641 31.0735 12.3429 31.0735Z"
                        stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M16.6074 10.7092V18.5521" stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M20.5234 10.7092V18.5521" stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M24.4414 10.7092V18.5521" stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                    <path d="M12.6895 10.7092V18.5521" stroke="black" stroke-width="2.14676" stroke-miterlimit="10" />
                </svg>

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