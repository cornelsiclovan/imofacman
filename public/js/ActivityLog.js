'use strict';

(function(window, $) {
    window.ActivityLog = function ($wrapper) {
        this.$wrapper = $wrapper;
        this.helper = new Helper($wrapper);

        this.$wrapper.find('.js-remove-department').on(
            'click',
            this.handleActivityLogDelete.bind(this)
        );
    };

    $.extend(window.ActivityLog.prototype,{
        handleActivityLogDelete: function (e) {
            e.preventDefault();


            var $link = $(e.currentTarget);
            var $el = $link.closest('tr');
            $link.find('.fa-trash')
                .removeClass('fa-trash')
                .addClass('fa-spinner')
                .addClass('fa-spin');

            var self = this;
            $.ajax({
                url: $link.data('url'),
                method: 'DELETE'
            }).done(function () {
                $el.fadeOut('normal', function () {
                    $el.remove();
                    self.updateTotalLogsNumber();
                });
            });
        },

        updateTotalLogsNumber: function () {
            var $rowNumberContainer = $('.js-row-number');
            $rowNumberContainer.html(
                this.helper.calculateTotalRows()
            );
        }
    });


    /**
     * A "private" object
     */
    var Helper = function ($wrapper) {
        this.$wrapper = $wrapper;
    };

    $.extend(Helper.prototype, {
        calculateTotalRows: function () {
            var $rowNumberContainer = $('.js-row-number');
            return $rowNumberContainer.html() - 1;
        }
    });




})(window, jQuery);