<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// 安全响应头
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

// 让主题使用的时区跟随 Typecho 设置的时区
setTimezoneByOffset($this->options->timezone);
// 检测是否包含主题配色 cookie
if (isset($_COOKIE['themeColor'])) {
    // 检测 cookie
    if ($_COOKIE['themeColor'] == 'light-color' or $_COOKIE['themeColor'] == 'dark-color') {
        // 根据主题配色 cookie 设置配色
        $GLOBALS['color'] = $_COOKIE['themeColor'];
    }else {
        // 如果 cookie 内容有问题就使用主题默认配色
        $GLOBALS['color'] = $this->options->themeColor;
    }
}else {
    // 如果不包含主题配色 cookie 就使用后台设置的默认配色
    $GLOBALS['color'] = $this->options->themeColor;
    // 如果设置了跟随系统主题并且浏览器是 IE
    if ($GLOBALS['color'] == 'auto-color' && isIE()) {
        // 默认使用浅色主题
        $GLOBALS['color'] = 'light-color';
    }
}

// 设置代码高亮主题
$codeThemeColor = $this->options->codeThemeColor;
// 如果代码高亮被禁用就不输出代码高亮主题设置
if ($this->options->codeHighlight != 'enable-highlight') {
    $codeThemeColor = 'code-theme-none';
}

// 导航栏自定义链接
$navLinks = null;
if ($this->options->navLinks) $navLinks = json_decode($this->options->navLinks, true);

// body class
$bodyClass = array(
    // 代码高亮主题
    $codeThemeColor,
    // 开启代码高亮
    $this->options->codeHighlight,
    // 主题配色模式
    $GLOBALS['color']
);
// 如果启用了代码高亮就添加代码块行号显示设置
if ($this->options->codeHighlight == 'enable-highlight') {
    $bodyClass[] = 'line-num-' . $this->options->codeLineNum;
}
// 把 body class 数组转为 string，方便直接输出
$bodyClass = implode(' ', $bodyClass);
?>

<!doctype html>
<html lang="<?php echo $GLOBALS['language']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--资源预连接和 DNS 预获取-->
    <link rel="dns-prefetch" href="https://www.gravatar.com">
    <link rel="dns-prefetch" href="<?php echo parse_url($this->options->siteUrl, PHP_URL_HOST); ?>">
    <link rel="preconnect" href="https://www.gravatar.com" crossorigin>
    <!--资源预加载-->
    <link rel="prefetch" href="<?php $this->options->themeUrl('assets/js/bundle-1774276299.js'); ?>" as="script">
    <!--搜索页添加 noindex-->
    <?php if ($this->is('search') && $this->options->searchPageNoindex == 'show'): ?>
        <meta name="robots" content="noindex, follow">
    <?php endif; ?>
    <!--归档页添加 noindex-->
    <?php if ($this->is('date') && $this->options->dateArchivePageNoindex == 'show'): ?>
        <meta name="robots" content="noindex, follow">
    <?php endif; ?>
    <title>
        <?php
        $this->archiveTitle(array(
            'category' => $GLOBALS['t']['archive']['postsUnderTheCategory'],
            'search' => $GLOBALS['t']['archive']['postsContainingTheKeyword'],
            'tag' => $GLOBALS['t']['archive']['postsTagged'],
            'author' => $GLOBALS['t']['archive']['postsByAuthor']
        ), '', ' - ');
        ?>
        <?php $this->options->title(); ?>
        <?php if ($this->is('index')) echo $this->options->tagline; ?>
    </title>
    <?php if ($this->is('post') && $this->fields->keywords or $this->fields->summaryContent): ?>
        <?php
        $metaContent = array();
        // 如果设置了自定义关键词就显示自定义关键词
        if ($this->fields->keywords) $metaContent['keywords'] = $this->fields->keywords;
        // 如果设置了自定义摘要内容就显示自定义摘要
        if ($this->fields->summaryContent) $metaContent['description'] = $this->fields->summaryContent;
        // 把包含自定义关键词和摘要的数组转为 URL 查询格式
        $metaContent = urldecode(http_build_query($metaContent));
        $this->header($metaContent);
        ?>
    <?php else: ?>
        <?php $this->header(); ?>
    <?php endif; ?>
    <link rel="icon" href="<?php echo $this->options->logoUrl?$this->options->logoUrl:$this->options->siteUrl . 'favicon.ico'; ?>" type="image/x-icon">
    <!--关键 CSS 内联，加速首屏渲染-->
    <style>
    body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;font-size:1rem;line-height:1.5;color:#333;background-color:#fff}
    .navbar{position:relative;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;padding:.5rem 1rem}
    .navbar-brand{display:inline-block;padding-top:.3125rem;padding-bottom:.3125rem;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap;color:#222;text-decoration:none}
    .container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}
    @media (min-width:576px){.container{max-width:540px}}
    @media (min-width:768px){.container{max-width:720px}}
    @media (min-width:992px){.container{max-width:960px}}
    @media (min-width:1200px){.container{max-width:1320px}}
    .post-card{position:relative;background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:8px;overflow:hidden;transition:box-shadow .2s;margin-bottom:1.5rem;padding:1.25rem;will-change:box-shadow}
    .post-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.1)}
    .post-card .card-link{position:absolute;inset:0;z-index:1}
    .post-card .card-body{position:relative;z-index:0}
    .post-card .card-row{display:flex;gap:1rem}
    .post-card .card-row .content-box{flex:1;min-width:0}
    .post-card .card-row .mini-thumb{width:180px;height:120px;aspect-ratio:3/2;flex-shrink:0;border-radius:6px;background-size:cover;background-position:center;overflow:hidden}
    .post-card .card-title{font-size:1.25rem;margin:0;color:inherit}
    .post-card .card-meta{font-size:.75rem;color:#888;white-space:nowrap}
    .post-card .card-meta a{color:#888}
    .post-card .card-summary{margin-top:.75rem;color:#555;font-size:.875rem;max-height:7.5em;overflow:hidden;display:-webkit-box;-webkit-line-clamp:5;-webkit-box-orient:vertical}
    .post-card .card-summary p{margin:0;line-height:1.5}
    .dark-color .post-card{background:#1a1a1f;border-color:rgba(255,255,255,.08)}
    .dark-color .post-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.3)}
    .dark-color .post-card .card-title{color:#d3d3d3}
    .dark-color .post-card .card-meta{color:#999}
    .dark-color .post-card .card-meta a{color:#999}
    .dark-color .post-card .card-summary{color:#bbb}
    @media (max-width:576px){.post-card .card-row .mini-thumb{width:120px}}
    a{color:#222;text-decoration:none}
    a:hover{color:#000}
    .dark-color a{color:#ddd}
    .dark-color a:hover{color:#fff}
    /*覆盖 Bootstrap 的 transition:all，仅动画可合成属性*/
    *{transition-property:transform,opacity,box-shadow,background-color,color,border-color!important;transition-duration:.2s!important;transition-timing-function:ease-in-out!important}
    </style>
    <!--非关键 CSS 延迟加载（media=print 避免阻塞渲染，onload 切换为 all）-->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/base.css'); ?>" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/components.css'); ?>" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/facile.css'); ?>" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/icon-font.css'); ?>" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/highlight.css'); ?>" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/icon-classes.css'); ?>" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/base.css'); ?>" type="text/css">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/components.css'); ?>" type="text/css">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/facile.css'); ?>" type="text/css">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/highlight.css'); ?>" type="text/css">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/icon-font.css'); ?>" type="text/css">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/icon-classes.css'); ?>" type="text/css">
    </noscript>
    <?php localizeScript(); ?>
    <!--自定义 CSS-->
    <?php if ($this->options->cssCode): ?>
        <style type="text/css"><?php $this->options->cssCode(); ?></style>
    <?php endif; ?>
    <!--主题色自定义样式-->
    <style>
    .btn-primary,.btn-primary.focus,.btn-primary:focus,.btn-primary:hover,.btn-primary:not(:disabled):not(.disabled).active,.btn-primary:not(:disabled):not(.disabled):active,.show>.btn-primary.dropdown-toggle{color:#fff;background-color:#222;border-color:#222}
    .btn-primary:hover,.btn-primary:focus{background-color:#000;border-color:#000}
    .badge-primary{color:#fff;background-color:#222}
    .text-primary{color:#222!important}.dark-color .text-primary{color:#eee!important}
    .bg-primary{background-color:#222!important}
    .border-primary{border-color:#222!important}
    </style>
    <!--自定义HTML-->
    <?php if ($this->options->headHTML): ?>
        <?php $this->options->headHTML(); ?>
    <?php endif; ?>
</head>
<body class="<?php echo $bodyClass; ?>" data-color="<?php echo $GLOBALS['color']; ?>" data-pjax="<?php $this->options->pjax(); ?>">
<?php if ($this->options->pjax == 'on' && $this->options->pjaxProgressBar == 'on'): ?>
<div id="progress-bar" style="display: none;">
    <div id="progress" class="bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"></div>
</div>
<?php endif; ?>
<header class="sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <?php if ($this->options->navLogoUrl): ?>
                <a class="navbar-brand" href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->title(); ?>">
                    <img src="<?php $this->options->navLogoUrl(); ?>" alt="<?php $this->options->title(); ?>" height="<?php $this->options->navLogoHeight(); ?>">
                </a>
            <?php else: ?>
                <a class="navbar-brand" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="<?php echo $GLOBALS['t']['header']['navigationMenu']; ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor03">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php if ($this->is('index')) echo 'active'; ?>">
                        <a class="nav-link" href="<?php $this->options->siteUrl(); ?>" <?php if ($this->is('index')) echo 'aria-current="page"'; ?>><?php echo $GLOBALS['t']['header']['home']; ?></a>
                    </li>
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                        <li class="nav-item <?php if ($this->is('page', $pages->slug)) echo 'active'; ?>">
                            <a class="nav-link" href="<?php $pages->permalink(); ?>" <?php if ($this->is('page', $pages->slug)) echo 'aria-current="page"'; ?>>
                                <?php $pages->title(); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>

                    <?php if ($this->options->navLinks && is_array($navLinks)): ?>
                        <!--自定义导航链接-->
                        <?php foreach ($navLinks as $link): ?>
                            <?php if (isset($link['menu']) && count($link['menu'])): ?>
                                <li class="nav-item dropdown">
                                    <a href="javascript:;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $link['name']; ?></a>
                                    <div class="dropdown-menu">
                                        <?php foreach ($link['menu'] as $menuItem): ?>
                                            <a class="dropdown-item" href="<?php echo $menuItem['url']; ?>"><?php echo $menuItem['name']; ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $link['url']; ?>"><?php echo $link['name']; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <!--主题配色切换按钮-->
                <button type="button" id="theme-color-toggle" class="btn btn-sm btn-outline-secondary mr-2" aria-label="<?php echo $GLOBALS['t']['sidebar']['themeColor']; ?>" title="<?php echo $GLOBALS['t']['sidebar']['themeColor']; ?>" data-toggle="tooltip" data-placement="bottom">
                    <span id="theme-color-icon"><?php echo $GLOBALS['color'] == 'dark-color' ? '🌙' : '☀️'; ?></span>
                </button>
                <form class="form-inline my-2 my-lg-0" action="<?php $this->options->siteUrl(); ?>" method="post" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="<?php echo $GLOBALS['t']['header']['search']; ?>" required name="s">
                        <div class="input-group-append">
                            <button class="btn btn-primary my-sm-0" type="submit" aria-label="<?php echo $GLOBALS['t']['header']['search']; ?>" title="<?php echo $GLOBALS['t']['header']['search']; ?>" data-toggle="tooltip" data-placement="bottom">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</header>