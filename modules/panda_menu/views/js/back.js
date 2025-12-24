$(document).ready(function () {
    // $("#url_category_selector").select2();

    PandaMenu.init();


    const $ajaxUpdatePositions = $('#ajaxUpdatePositions');
    if ($ajaxUpdatePositions.length > 0) {
        const ajaxUrl = $ajaxUpdatePositions.data('url');
        $('#table-panda_menu_elements tbody').sortable({
            handle: '.dragHandle',
            update: function (event, ui) {
                var orderedIds = $(this).children('tr').map(function () {
                    var id = $(this).find('td.dragHandle').attr('id');
                    id = id.replace('td_1_', ''); // Remove the prefix 'id_1_' to get the actual ID
                    return id;
                }).get();
                const childs = $(this).children('tr');
                console.log('New order:', orderedIds);

                // Send the new order to the backend for saving
                $.ajax({
                    type: 'POST',
                    url: ajaxUrl,
                    data: {
                        order: orderedIds
                    },
                    success: function (response) {
                        childs.each(function (index, element) {
                            $(element).find('td.dragHandle .positions').text(index + 1);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error occurred updating positions: ', error);
                        alert('Could not update positions. Please try again.');
                    }
                });
            }
        });
    }

});

const PandaMenu = {
    selectors: {
        form: '#panda_menu_elements_form',
        url_type: 'select[name="url_type"]',
        url_text: 'input[name="url_text"]',
        url_category: 'input[name="url_category"]',
        submenu: 'input[name="submenu"]',
        submenu_title: 'input[name="submenu_title"]',
        submenu_type: 'select[name="submenu_type"]',
        label_highlighted: 'input[name="label_highlighted"]',
        label_text: 'input[name="label_text"]',
        label_text_color: 'input[name="label_text_color"]',
        label_color: 'input[name="label_color"]',
        icon_highlighted: 'input[name="icon_highlighted"]',
        icon_selected: 'select[name="icon"]',
        column_width: 'select[name="column_width"]',
        highlighted: 'input[name="highlighted"]',
    },
    init: function () {
        this.getElements();
        this.bindEvents();
        this.prepareForm();

    },

    getElements: function () {
        this.$form = $(this.selectors.form);
        this.$urlType = $(this.selectors.url_type);
        this.$urlTextWrapper = $(this.selectors.url_text).closest('.form-group');
        this.$urlCategoryWrapper = $(this.selectors.url_category).closest('.form-group');
        this.$submenu = $(this.selectors.submenu);
        this.$submenuTitleWrapper = $(this.selectors.submenu_title).closest('.form-group');
        this.$submenuTypeWrapper = $(this.selectors.submenu_type).closest('.form-group');
        this.$labelhighlighted = $(this.selectors.label_highlighted);
        this.$labelTextWrapper = $(this.selectors.label_text).closest('.form-group');
        this.$labelColorWrapper = $(this.selectors.label_color).closest('.form-group');
        this.$labelTextColorWrapper = $(this.selectors.label_text_color).closest('.form-group');
        this.$iconhighlighted = $(this.selectors.icon_highlighted);
        this.$iconSelectedWrapper = $(this.selectors.icon_selected).closest('.form-group');
        this.$columnWidthWrapper = $(this.selectors.column_width).closest('.form-group');
        this.$highlighted = $(this.selectors.highlighted);
    },
    prepareForm: function () {

        this.handleUrlTypeChange(this.$urlType);
        this.handleSubmenuChange();
        this.handleLabelhighlightedChange();
        this.handleIconhighlightedChange();

    },
    bindEvents: function () {
        const $self = this;
        this.$urlType.on('change', function () {
            $self.handleUrlTypeChange($(this));

        });
        this.$submenu.on('change', function () {
            $self.handleSubmenuChange();
        });
        this.$labelhighlighted.on('change', function () {
            $self.handleLabelhighlightedChange();
           
        });
        this.$highlighted.on('change', function () {
            $self.handlehighlightedChange();
        });
        this.$iconhighlighted.on('change', function () {
            $self.handleIconhighlightedChange();
           
        });
    },

    handleUrlTypeChange: function ($select) {
        const selectedValue = $select.val();
        if (selectedValue === 'category') {
            this.$urlTextWrapper.hide();
            this.$urlCategoryWrapper.show();
        } else {
            this.$urlTextWrapper.show();
            this.$urlCategoryWrapper.hide();
        }
    },
    handleSubmenuChange: function () {
        const $checkbox = $(this.selectors.submenu + ':checked');
        if ($checkbox.val() == 1) {
            this.$submenuTitleWrapper.show();
            this.$submenuTypeWrapper.show();
            this.$columnWidthWrapper.show();
        } else {
            this.$submenuTitleWrapper.hide();
            this.$submenuTypeWrapper.hide();
            this.$columnWidthWrapper.hide();
        }
    },
    handleLabelhighlightedChange: function () {
        const $checkbox = $(this.selectors.label_highlighted + ':checked');
        if ($checkbox.val() == 1) {
            this.$labelTextWrapper.show();
            this.$labelColorWrapper.show();
            this.$labelTextColorWrapper.show();
            this.hidehighlighted();
            this.hideIconhighlighted();
        } else {
            this.$labelTextWrapper.hide();
            this.$labelColorWrapper.hide();
            this.$labelTextColorWrapper.hide();
        }
    },
    handleIconhighlightedChange: function () {
       
        const $checkbox = $(this.selectors.icon_highlighted + ':checked');
        if ($checkbox.val() == 1) {
            this.$iconSelectedWrapper.show();
            this.hidehighlighted();
            this.hideLabelhighlighted();
        } else {
            this.$iconSelectedWrapper.hide();
        }
    },
    handlehighlightedChange: function () {
       
        const $checkbox = $(this.selectors.highlighted + ':checked');
        if ($checkbox.val() == 1) {
            this.hideLabelhighlighted();
            this.hideIconhighlighted();
        }
    },
    hidehighlighted: function () {
        
        const $checkbox = $(this.selectors.highlighted + ':checked');
        if($checkbox.val() == 1) {
              $('#highlighted_off').prop('checked', true);
                $checkbox.trigger('change');
        }
 
    },
    hideLabelhighlighted: function () {
        const $checkbox = $(this.selectors.label_highlighted + ':checked');
        if($checkbox.val() == 1) {
           $('#label_highlighted_off').prop('checked', true);
           $checkbox.trigger('change');
        }
    },
    hideIconhighlighted: function () {
        const $checkbox = $(this.selectors.icon_highlighted + ':checked');
        if($checkbox.val() == 1) {
           $('#icon_highlighted_off').prop('checked', true);
           $checkbox.trigger('change');
        }
    }
}
