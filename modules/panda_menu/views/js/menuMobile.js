
// 'use strict';

// if (!document.querySelector("#checkout")) {
//     const ACCORDION_INSTANCES = [];

//     class Accordion {
//         constructor(domNode) {
//             this.rootEl = domNode;
//             this.buttonEl = this.rootEl.querySelector('#header .ob-accordion__trigger[aria-expanded]');
//             const controlsId = this.buttonEl.getAttribute('aria-controls');
//             this.contentEl = document.getElementById(controlsId);
//             this.open = this.buttonEl.getAttribute('aria-expanded') === 'true';

//             ACCORDION_INSTANCES.push(this);

//             if (this.open) {
//                 this.contentEl.style.maxHeight = 'none';
//                 this.contentEl.removeAttribute('hidden');
//             } else {
//                 this.contentEl.style.maxHeight = '0';
//                 this.contentEl.setAttribute('hidden', '');
//             }

//             this.buttonEl.addEventListener('click', this.onButtonClick.bind(this));
//         }

//         onButtonClick() {
//             if (!this.open) {
//                 ACCORDION_INSTANCES.forEach(acc => {
//                     if (acc !== this) acc.closeAccordion();
//                 });
//             }
//             this.toggle(!this.open);
//         }

//         toggle(open) {
//             if (open === this.open) return;
//             this.open = open;
//             this.buttonEl.setAttribute('aria-expanded', `${open}`);
//             const content = this.contentEl;

//             if (open) {
//                 content.removeAttribute('hidden');
//                 content.style.maxHeight = content.scrollHeight + 'px';
//                 content.addEventListener('transitionend', function handler(e) {
//                     if (e.propertyName === 'max-height') {
//                         content.style.maxHeight = 'none';
//                         content.removeEventListener('transitionend', handler);
//                     }
//                 });
//             } else {
//                 content.style.maxHeight = content.scrollHeight + 'px';
//                 setTimeout(() => {
//                     content.style.maxHeight = '0';
//                 }, 10);
//                 content.addEventListener('transitionend', function handler(e) {
//                     if (e.propertyName === 'max-height') {
//                         content.setAttribute('hidden', '');
//                         content.removeEventListener('transitionend', handler);
//                     }
//                 });
//             }
//         }

//         openAccordion() {
//             this.toggle(true);
//         }

//         closeAccordion() {
//             this.toggle(false);
//         }
//     }

//     function initAccordionsAndLayout() {
//         ACCORDION_INSTANCES.length = 0;

//         const accordions = document.querySelectorAll('#header .ob-accordion .ob-accordion__heading');
//         accordions.forEach(el => new Accordion(el));
//     }

//     function setupMobileMenu() {
//         const mobileMenuBtn = document.querySelector("#burger-btn");
//         const html = document.querySelector("html");
//         const header = document.querySelector("#header");

//         mobileMenuBtn.addEventListener("click", () => {
//             const isOpening = !header.classList.contains("menu-mobile-opened");

//             header.classList.toggle("menu-mobile-opened");
//             html.classList.toggle("ob-mobile-opened");

//             if (isOpening) {
//                 if (mobileMenuBtn && mobileMenuBtn.type === "checkbox") {
//                     mobileMenuBtn.checked = true;
//                 }
//             }
//         });
//     }

//     window.addEventListener('DOMContentLoaded', () => {
//         // initAccordionsAndLayout();
//         setupMobileMenu();
//     });

//     window.addEventListener('resize', () => {
//         // initAccordionsAndLayout();
//     });

// }

$(document).ready(function () {

    // Otwieranie / zamykanie menu
    $("#burger-btn .header-top__link").on("click", function(e) {
        e.preventDefault();
        e.stopPropagation();

        $(".menu-dialog").toggleClass("is-open");
    });

    // Zamknięcie po kliknięciu poza menu
    $(document).on("click", function() {
        $(".menu-dialog").removeClass("is-open");
    });

    // Blokada propagacji w środku menu
    $(".menu-dialog").on("click", function(e) {
        e.stopPropagation();
    });

});

document.addEventListener("DOMContentLoaded", function () {
    const triggers = document.querySelectorAll('.panda-accordion__trigger');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', function () {
            const accordion = trigger.closest('.panda-accordion');
            if (!accordion) return;

            const panel = accordion.querySelector('.panda-accordion__panel');
            if (!panel) return;

            let isOpen = trigger.getAttribute('aria-expanded') === 'true';
            trigger.setAttribute('aria-expanded', String(!isOpen));

            panel.style.display = !isOpen ? 'block' : 'none';
        });
    });
});




