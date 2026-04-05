<script src="js/bootstrap.bundle.min.js"></script>
<script>
  function setNavbarHeightVar() {
    var nav = document.querySelector('.navbar.fixed-top') || document.querySelector('.navbar');
    if (!nav) return;
    var height = nav.offsetHeight || 0;
    document.documentElement.style.setProperty('--navbar-height', height + 'px');
  }

  document.addEventListener('DOMContentLoaded', function() {
    var main = document.getElementById('main-content');
    if (main) {
      main.focus({ preventScroll: false });
    }

    // Initial set and subsequent recalculations
    setNavbarHeightVar();
    window.addEventListener('resize', setNavbarHeightVar);
    window.addEventListener('load', setNavbarHeightVar);
    window.addEventListener('orientationchange', setNavbarHeightVar);

    // visualViewport fires on pinch/zoom in many browsers
    if (window.visualViewport) {
      window.visualViewport.addEventListener('resize', setNavbarHeightVar);
      window.visualViewport.addEventListener('scroll', setNavbarHeightVar);
    }

    // Small short-lived polling to catch zoom changes in browsers that don't emit events
    (function shortPolling() {
      var checks = 0;
      var iv = setInterval(function() {
        setNavbarHeightVar();
        if (++checks > 20) clearInterval(iv);
      }, 250);
    })();

    // Watch for changes in the navbar (collapse toggles, dynamic content)
    var nav = document.querySelector('.navbar');
    if (nav && window.MutationObserver) {
      var observer = new MutationObserver(function() { setNavbarHeightVar(); });
      observer.observe(nav, { attributes: true, childList: true, subtree: true });
    }

    // Bootstrap collapse events (if present)
    var bsCollapse = document.getElementById('navbarSupportedContent');
    if (bsCollapse) {
      bsCollapse.addEventListener('shown.bs.collapse', setNavbarHeightVar);
      bsCollapse.addEventListener('hidden.bs.collapse', setNavbarHeightVar);
    }
  });
</script>