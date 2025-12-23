<div class="header-top__block header-top__block--search col">

    <div id="_desktop_search_from" class="d-none d-md-block">
        <form role="search" class="search-form js-search-form" data-search-controller-url="{$ajax_search_url}"
            method="get" action="{$search_controller_url}">
            <div class="search-form__form-group">

                <input type="hidden" name="controller" value="search">
                <label for="search-input" class="visually-hidden">
                    {l s='Wpisz czego szukasz' d='Shop.Forms.Labels'}
                </label>
                <input id="search-input" class="js-search-input search-form__input form-control"
                    placeholder="{l s='Enter what you are looking for' d='Modules.Issearchbar.Form'}" type="text"
                    name="s" value="{$search_string}">
                <button type="submit" class="search-form__btn btn" aria-label="{l s='Wyszukaj' d='Shop.Forms.Actions'}">
                    <img src="{$urls.theme_assets}img/header/search.png" alt="">
                </button>
            </div>
        </form>
    </div>

    <a role="button" class="search-toggler header-top__link d-block d-md-none" data-toggle="modal"
        data-target="#saerchModal">
        <div class="header-top__icon-container">
            <img src="{$urls.theme_assets}img/header/search.png" alt="Otwórz wyszukiwarkę">

        </div>
    </a>

</div>