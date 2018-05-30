/*jshint esversion: 6 */
(function ($) {

    'use strict';

    const EPFWRollBack = {

        /**
         * Function used to instantiate the DialogsManager
         * It basically creates a "screen" used for displaying the plugin rollback progress
         */
        main: function () {

            $('.epfw-rollback-button').on('click', function (event) {

                event.preventDefault();

                let dialogsManager = new DialogsManager.Instance();

                dialogsManager.createWidget('confirm', {
                    headerMessage: EPFWRollbackConfig.i18n.rollback_to_previous_version,
                    message: EPFWRollbackConfig.i18n.rollback_confirm,
                    strings: {
                        confirm: EPFWRollbackConfig.i18n.yes,
                        cancel: EPFWRollbackConfig.i18n.cancel
                    },
                    onConfirm: function () {
                        $(this).addClass('loading');

                        location.href = $(this).attr('href');
                    }
                }).show();
            });
        }

    };

    $(document).ready(function () {
        EPFWRollBack.main();
    });

})(jQuery);
