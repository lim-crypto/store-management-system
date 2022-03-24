$(document).ready(function() {
    var activePage = window.location;
    $('.nav-sidebar li a').each(function() {
      var currentPage = this.href;
      if (activePage == currentPage) {
        $(this).addClass('active');
      }
    });
  });