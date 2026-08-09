/*!
* Mobile directory toggle - extracted from Facile Directory module
* Handles #directory-btn click to show/hide #directory-mobile panel
*/
(function() {
  var isShow = false;

  function initDirectoryToggle() {
    if (!document.getElementById('directory-mobile')) return;

    // Reset state
    isShow = false;

    // Mobile directory button click
    $('#directory-btn').on('click', function() {
      if (!isShow) {
        // Show directory
        $('#directory-mobile').css('display', 'flex');
        $('#directory-mobile').animate({opacity: 1}, 250);
        isShow = true;
      } else {
        // Hide directory
        $('#directory-mobile').animate({opacity: 0}, 250, function() {
          $('#directory-mobile').hide();
        });
        isShow = false;
      }
      // Update aria-expanded for screen readers
      $('#directory-btn').attr('aria-expanded', isShow);
    });

    // Close directory button click
    $('#directory-mobile .close-btn').on('click', function() {
      $('#directory-btn').click();
    });
  }

  // Initialize on DOM ready
  $(function() {
    initDirectoryToggle();
  });

  // Also expose for PJAX re-init
  window.initDirectoryToggle = initDirectoryToggle;
})();
