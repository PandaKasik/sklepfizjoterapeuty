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
<div class="col flex-grow-0 header-top__block header-top__block--user">
  <a class="header-top__link" rel="nofollow" href="{$urls.pages.authentication}?back={$urls.current_url|urlencode}"
    {if $logged} title="
      {l s='View my customer account' d='Shop.Theme.Customeraccount'}" 
    {else}
    title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}" {/if}>
    <div class="header-top__icon-container">
      <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="16.0734" cy="16.0735" rx="14.9992" ry="15" stroke="black" stroke-width="2.14676" />
        <ellipse cx="16.1386" cy="10.9011" rx="5.68935" ry="5.68965" stroke="black" stroke-width="2.14676" />
        <path
          d="M24.1876 29.0368C24.1876 24.4662 20.4825 20.761 15.9121 20.761C11.3418 20.761 7.63672 24.4662 7.63672 29.0368"
          stroke="black" stroke-width="2.14676" />
      </svg>

    </div>
  </a>
</div>