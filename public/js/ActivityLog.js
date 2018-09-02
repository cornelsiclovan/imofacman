'use strict';

(function(window, $, swal) {
    window.ActivityLog = function ($wrapper) {
        this.$wrapper = $wrapper;
        this.helper = new Helper($wrapper);

        this.$wrapper.on(
            'click',
            '.js-remove-department',
            this.handleActivityLogDelete.bind(this)
        );

        this.$wrapper.on(
            'submit',
            '.js-new-activity-form',
            this.handleNewFormSubmit.bind(this)
        );
    };

    $.extend(window.ActivityLog.prototype,{
        _selectors:{
            newDepartmentForm: '.js-js-new-activity-log-form-wrapper'
        },

        handleActivityLogDelete: function (e) {
            e.preventDefault();

            var $link = $(e.currentTarget);
            var self = this;
            swal({
                title: 'Sterg acest departament?',
                showCancelButton: true
            }).then(
                function () {
                    self._deleteActivityLog($link);
                },
                function () {

                }
            );
        },

        _deleteActivityLog: function($link){
            var $el = $link.closest('tr');

            $link.find('.fa-trash')
                .removeClass('fa-trash')
                .addClass('fa-spinner')
                .addClass('fa-spin');

            var self = this;
            $.ajax({
                url: $link.data('url'),
                method: 'DELETE',
            }).then(function(){
                $el.remove();
                self.updateTotalLogsNumberOnRemove();
            }).catch(function(jqXHR){
                if(typeof jqXHR.responseText === 'undefined'){
                    throw jqXHR;
                }
            }).catch(function(e){
                console.log(e);
            });
        },

        updateTotalLogsNumber: function () {
            var $rowNumberContainer = $('.js-row-number');
            $rowNumberContainer.html(
                this.helper.calculateTotalRows()
            );
        },

        updateTotalLogsNumberOnRemove: function(){
            var $rowNumberContainer = $('.js-row-number');
            $rowNumberContainer.html(
                this.helper.removeRow()
            );
        },

        handleNewFormSubmit: function(e){
            e.preventDefault();

            var $form = $(e.currentTarget);
            var $tbody = this.$wrapper.find('tbody');
            var self = this;
            $.ajax({
               url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                success: function(data){
                    $tbody.append(data);
                    self.updateTotalLogsNumber();
                    self._removeFormErrors();
                },
                error: function(jqXHR){

                    $form.closest('.js-new-activity-log-form-wrapper')
                        .html(jqXHR.responseText);
                }
            });
        },

        _removeFormErrors: function(){
            var $form = this.$wrapper.find('.js-new-activity-log-form-wrapper');
            $form.find('.js-field-error').remove();
            $form.find('.help-block').remove();
            $form.find('.glyphicon-remove').remove();
            $form.find('.form-group').removeClass('has-error');
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
            var $i = parseInt(this.$wrapper.find('.js-row-number').html());
            var $j = 1;
            this.$wrapper.find('tbody tr').each(function(){
                $(this).find('th').html($j);
                $j += 1;
            });
            $i = $i + 1;
            return $i;
        },

        removeRow: function(){
            var $numRows = this.$wrapper.find('.js-row-number').html();
            var $j = 1;
            this.$wrapper.find('tbody tr').each(function(){
                $(this).find('th').html($j);
                $j += 1;
            });
            $numRows --;
            return $numRows;
        }
    });




})(window, jQuery, swal);