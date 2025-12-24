$(document).ready(function() {
    new PandaMenuScreenWidth();
});

class PandaMenuScreenWidth {
    cookieName = 'panda_screen_width';

    constructor() {
        // ustaw cookie przy starcie jeśli nie istnieje
        if (!this.isSetCookie()) {
            this.setCookieValue(window.innerWidth);
        }

        // nasłuchiwanie na resize + debounce
        window.addEventListener(
            'resize',
            this.debounce(() => {
                this.setCookieValue(window.innerWidth);
            }, 300)
        );
    }

    setCookieValue(value) {
        const d = new Date();
        d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000)); // 1 year
        const expires = "expires=" + d.toUTCString();
        document.cookie = this.cookieName + "=" + value + ";" + expires + ";path=/";
    }

    getCookieValue() {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${this.cookieName}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    isSetCookie() {
        return document.cookie.split(';').some(item =>
            item.trim().startsWith(this.cookieName + '=')
        );
    }

    // ✅ debounce
    debounce(func, wait = 300) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(this, args);
            }, wait);
        };
    }
}
