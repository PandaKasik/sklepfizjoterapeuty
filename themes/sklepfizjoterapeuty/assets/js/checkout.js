(()=>{(()=>{"use strict";var c={};c.n=o=>{var e=o&&o.__esModule?()=>o.default:()=>o;return c.d(e,{a:e}),e},c.d=(o,e)=>{for(var a in e)c.o(e,a)&&!c.o(o,a)&&Object.defineProperty(o,a,{enumerable:!0,get:e[a]})},c.o=(o,e)=>Object.prototype.hasOwnProperty.call(o,e);var d={};(()=>{const o=jQuery;var e=c.n(o);const a=prestashop;var r=c.n(a);/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
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
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */function s(){e()(r().themeSelectors.checkout.termsLink).on("click",t=>{t.preventDefault();let n=e()(t.target).attr("href");n&&(n+="?content_only=1",e().get(n,l=>{e()(r().themeSelectors.modal).find(r().themeSelectors.modalContent).html(e()(l).find(".page-cms").contents())}).fail(l=>{r().emit("handleError",{eventType:"clickTerms",resp:l})})),e()(r().themeSelectors.modal).modal("show")}),e()(r().themeSelectors.checkout.giftCheckbox).on("click",()=>{e()("#gift").slideToggle()})}e()(document).ready(()=>{e()("body#checkout").length===1&&s(),r().on("updatedDeliveryForm",t=>{typeof t.deliveryOption=="undefined"||t.deliveryOption.length===0||(e()(r().themeSelectors.checkout.carrierExtraContent).hide(),t.deliveryOption.next(r().themeSelectors.checkout.carrierExtraContent).show())}),r().on("changedCheckoutStep",t=>{typeof t.event.currentTarget!="undefined"&&e()(".collapse",t.event.currentTarget).not(".show").not(".collapse .collapse").collapse("show")})}),e()(document).on("change",'.checkout-option input[type="radio"]',t=>{const l=e()(t.currentTarget).closest(".checkout-option");l.parent().find(".checkout-option").removeClass("selected"),l.addClass("selected")}),e()(document).on("click",".js-checkout-step-header",t=>{const n=e()(t.currentTarget).data("identifier");e()(`#${n}`).addClass("-current"),e()(`#content-${n}`).collapse("show").scrollTop()})})()})();})();
