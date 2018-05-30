/*jshint esversion: 6 */
(function ($) {

  'use strict';

  const EPFWBackEndObject = {

    /**
     * Function used to handle admin UI postboxes
     */
    admin_postboxes: function () {

      if (typeof postboxes !== 'undefined') { // sanity check
        postboxes.add_postbox_toggles(pagenow);

        // set cursor to pointer
        $('.postbox .hndle').css('cursor', 'pointer');
      }
    },

    /**
     * Handle accordion visibility
     */
    admin_accordions: function () {

      let main_wrapper = '.epfw-field-slide-up-header'; // the main wrapper
      let accordion_wrapper = '.epfw-accordion-wrapper'; // actual accordion wrapper, that is nested and holds the actual contents
      let accordion_visibility = 'epfw-accordion-visible'; // not a CSS selector, but an existing CSS class that adds display: none

      $(main_wrapper).on('click', function () {

        if ($(this).parent().hasClass(accordion_visibility)) {
          $(this).parent().removeClass(accordion_visibility);
          $(this).parent().find(accordion_wrapper).hide(250);
        } else {
          $(this).parent().addClass(accordion_visibility);
          $(this).parent().find(accordion_wrapper).show(250);
        }
      });
    },

    /**
     * Handle UI tab switching via jQuery instead of relying on CSS only
     */
    admin_tab_switching: function () { /** @todo: find a smarter way of writing this */

      let nav_tab_selector = '.epfw-tab';
      let turn_into_tab = '.epfw-turn-into-tab';
      /**
       * Default tab handling
       */

      // make the first tab active by default
      $(nav_tab_selector + ':first').addClass('nav-tab-active');

      // make all the tabs, except the first one hidden
      $(turn_into_tab).not(':first').hide();

      /**
       * Listen for click events on nav-tab links
       */
      $(nav_tab_selector).on('click', function (event) {

        $(nav_tab_selector).removeClass('nav-tab-active'); // remove active class from all nav_tab_selectors
        $(this).addClass('nav-tab-active'); // add class to currently clicked selector

        let clicked_tab = $(this).attr('href');

        $('.epfw-turn-into-tab').each(function () {
          if ('#' + $(this).attr('id') !== clicked_tab) {
            $(this).hide();
          }

          $(clicked_tab).fadeIn(150);

        });
      });
    },

    /**
     * Function used to instantiate the DialogsManager
     * It basically creates a "screen" used for displaying the plugin rollback progress
     */
    rollback: function () {

      $('.epfw-rollback-button').on('click', function (event) {

        event.preventDefault();

        let dialogsManager = new DialogsManager.Instance();

        dialogsManager.createWidget('confirm', {
          headerMessage: EPFWAdminConfig.i18n.rollback_to_previous_version,
          message: EPFWAdminConfig.i18n.rollback_confirm,
          strings: {
            confirm: EPFWAdminConfig.i18n.yes,
            cancel: EPFWAdminConfig.i18n.cancel
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
    EPFWBackEndObject.admin_postboxes();
    EPFWBackEndObject.admin_tab_switching();
    EPFWBackEndObject.admin_accordions();
    EPFWBackEndObject.rollback();
  });

})(jQuery);