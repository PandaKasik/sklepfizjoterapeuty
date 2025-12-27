{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
{block name='header_banner'}
    <div class="header-banner">
        {hook h='displayBanner'}
    </div>
{/block}

{block name='header_nav'}
    <nav class="header-nav d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-3"></div>
                <div class="col-9">
                    <div class="recomendation">
                        {l s='Polecany przez fizjoterapeutów' d='Shop.Theme.Global'}
                    </div>
                    <div class="contact-info">
                        <div class="sociale">
                            <div class="facebook">
                                <a href="https://www.facebook.com/fizjoterapeuty"
                                    title="Profil na Facebooku - otwiera się w nowej karcie" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="{$urls.theme_assets}img/header/fb-icon.png" alt="">
                                </a>

                            </div>
                            <div class="instagram">
                                <a href="https://www.instagram.com/fizjoterapeuty/"
                                    title="Profil na Instagramie - otwiera się w nowej karcie" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="{$urls.theme_assets}img/header/instagram-icon.png" alt="">
                                </a>

                            </div>
                            <div class="youtube">
                                <a href="https://www.youtube.com/c/PortalFizjoterapeuty"
                                    title="Profil na YouTube - otwiera się w nowej karcie" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="{$urls.theme_assets}img/header/yt-icon.png" alt="">
                                </a>

                            </div>
                        </div>
                        <div class="mail">
                            <a href="mailto:sklep@fizjoterapeuty.pl">
                                <img src="{$urls.theme_assets}img/header/mail-icon.png" alt="">
                                {l s='sklep@fizjoterapeuty.pl'  d='Shop.Theme.Global'}
                            </a>
                        </div>
                        <div class="phone-number">
                            <a href="tel:+48513776935">
                                <img src="{$urls.theme_assets}img/header/phone-icon.png" alt="">
                                {l s='+48 513 776 935' d='Shop.Theme.Global'}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
{/block}

{block name='header_top'}
    <div class="js-header-top-wrapper">

        <div class="header-top ">
            <div class="header-top__content pt-md-3 pb-md-0 py-2">

                <div class="container">

                    <div class="row header-top__row">

                        <div class="col flex-grow-0 header-top__block header-top__block--menu-toggle d-block d-md-none">
                            <a class="header-top__link" rel="nofollow" href="#" data-toggle="modal"
                                data-target="#mobile_top_menu_wrapper">
                                <div class="header-top__icon-container">
                                    <span class="header-top__icon material-icons">menu</span>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col header-top__block header-top__block--logo">
                            <div class="logo-wrapper">
                                <a href="{$urls.pages.index}">
                                    {images_block webpEnabled=$webpEnabled}
                                    <img {if !empty($shop.logo_details)} src="{$shop.logo_details.src}"
                                        width="{$shop.logo_details.width}" height="{$shop.logo_details.height}" {else}
                                        src="{$shop.logo}" {/if} class="logo img-fluid"
                                        alt="{$shop.name} {l s='logo' d='Shop.Theme.Global'}">
                                    {/images_block}
                                </a>
                            </div>

                        </div>
                        <div class="top-wrapper">
                            {hook h='displayTop'}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="menu_desktop" class="pc_desktop_menu container _desktop_menu_desktop">

        {hook h='displayNavPandaMenu' menu=1}
        {hook h='displayNavPandaMenu' menu=2}
    </div>
{/block}