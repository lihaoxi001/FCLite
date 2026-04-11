<!-- Facile Theme by Changbin (https://github.com/changbin1997/Facile) -->
<footer>
    <div class="container py-3">
        <?php if ($this->options->icp): ?>
            <nav class="text-center mb-1"><?php $this->options->icp(); ?></nav>
        <?php endif; ?>
    </div>
</footer>

<button class="btn text-primary rounded-circle d-none" id="to-top-btn" type="button" aria-label="<?php echo $GLOBALS['t']['scrollToTop']; ?>" title="<?php echo $GLOBALS['t']['scrollToTop']; ?>">
    <i class="icon-arrow-up"></i>
</button>

<!--PJAX 更新完成后执行的 JS-->
<?php if ($this->options->pjax === 'on' && $this->options->pjaxEnd): ?>
    <script><?php $this->options->pjaxEnd(); ?></script>
<?php endif; ?>

<!--独立 JS 文件加载，替代损坏的 webpack bundle-->
<script src="<?php $this->options->themeUrl('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/jquery.pjax.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/highlight.pack.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/qrious.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/clipboard.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('assets/js/directory-toggle.js'); ?>"></script>
<script>
(function(){
    var toggler = document.querySelector('.navbar-toggler');
    var target = toggler ? toggler.getAttribute('data-target') : null;
    var collapseEl = target ? document.querySelector(target) : null;
    if (!toggler || !collapseEl) return;

    toggler.addEventListener('click', function(e){
        e.preventDefault();
        var isShown = collapseEl.classList.contains('show');
        if (isShown) {
            collapseEl.classList.remove('show');
            toggler.setAttribute('aria-expanded', 'false');
        } else {
            collapseEl.classList.add('show');
            toggler.setAttribute('aria-expanded', 'true');
        }
    });
})();
</script>
<script>
(function(){
    var toggleBtn = document.getElementById('theme-color-toggle');
    var icon = document.getElementById('theme-color-icon');
    if (!toggleBtn) return;

    function getTheme() {
        return document.body.classList.contains('dark-color') ? 'dark' : 'light';
    }

    function setTheme(mode) {
        var cookieVal = mode === 'dark' ? 'dark-color' : 'light-color';
        var expires = new Date(Date.now() + 15552e6);
        document.cookie = 'themeColor=' + cookieVal + ';path=/;expires=' + expires.toUTCString();
        document.body.classList.remove(document.body.getAttribute('data-color'));
        document.body.classList.add(cookieVal);
        document.body.setAttribute('data-color', cookieVal);

        if (icon) {
            icon.textContent = mode === 'dark' ? '🌙' : '☀️';
        }

        if (document.querySelector('.follow-theme-color')) {
            document.body.classList.remove('stackoverflow-light', 'vs2015');
            document.body.classList.add(mode === 'dark' ? 'vs2015' : 'stackoverflow-light');
        }
    }

    toggleBtn.addEventListener('click', function() {
        var current = getTheme();
        var next = current === 'dark' ? 'light' : 'dark';
        setTheme(next);
    });
})();
</script>
    <!--自定义HTML-->
<?php if ($this->options->bodyHTML): ?>
    <?php $this->options->bodyHTML(); ?>
<?php endif; ?>

<?php $this->footer(); ?>
</body>
</html>
