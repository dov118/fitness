import * as $ from 'jquery';
import ClickEvent = JQuery.ClickEvent;

$(window).on('load', (): void => {
  if ($('.Toast')) {
    let timeout: number = 0;
    $('.Toast-dismissButton').on('click', (event: ClickEvent): void => {
      $(event.target).closest('.Toast').hide();
      clearTimeout(timeout);
    });

    timeout = setTimeout((): void => {
      $('.Toast').hide();
    }, 3000);
  }
});