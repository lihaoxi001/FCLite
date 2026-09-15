<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$GLOBALS['page'] = 'archive';

// 语言初始化

$this->need('components/header.php');
?>

<main class="container main" id="main">
    <div class="row mt-4">
        <div class="col-xl-8 col-lg-8 post-list">
            <?php if ($this->options->breadcrumb == 'on'): ?>
                <nav aria-label="<?php echo '页面路径'; ?>" class="breadcrumb-nav bg">
                    <ol class="breadcrumb m-0 pl-0 pr-0 pt-0 border-0">
                        <li class="breadcrumb-item">
                            <a href="<?php $this->options->siteUrl(); ?>"><?php echo '首页'; ?></a>
                        </li>
                        <li tabindex="0" class="breadcrumb-item active" aria-current="page"><?php $this->archiveTitle(' &raquo; ','',''); ?></li>
                    </ol>
                </nav>
            <?php endif; ?>
            <header class="archive-title mb-5">
                <h1>
                    <?php $this->archiveTitle(array(
                        'category' => '分类 %s 下的文章',
                        'search' => '包含关键字 %s 的文章',
                        'tag' => '包含 %s 标签的文章',
                        'author' => '%s 发布的文章'
                    ), '', ''); ?>
                </h1>
                <?php if ($this->getDescription() != ''): ?>
                    <span class="archive-description"><?php echo $this->getDescription(); ?></span>
                <?php endif; ?>
            </header>
            <?php if ($this->have()): ?>
                <?php $this->need('components/post-list.php'); ?>
            <?php else: ?>
                <article class="no-content">
                    <hr>
                    <h4 class="mb-3" role="alert"><?php printf('无法查找到包含 %s 的文章！', '<b>' . $this->archiveTitle . '</b>') ?></h4 >
                    <p><?php echo '您可以尝试：'; ?></p>
                    <ol class="pl-3 mb-5">
                        <li><?php echo '更换关键字重新搜索'; ?></li>
                        <li><?php echo '在右侧或下方的文章分类区域选择分类查找'; ?></li>
                        <li><?php echo '在右侧或下方的标签云区域选择标签查找'; ?></li>
                    </ol>
                </article>
            <?php endif; ?>
            <nav class="page-nav my-5" aria-label="<?php echo '分页导航'; ?>">
                <?php bootstrap4Pagination($this, '上一页（左光标键）', '下一页（右光标键）'); ?>
            </nav>
        </div>
        <?php $this->need('components/sidebar.php'); ?>
    </div>
</main>

<?php $this->need('components/footer.php'); ?>