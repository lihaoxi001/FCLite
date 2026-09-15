<?php
/**
 * 网站数据
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// 让主题使用的时区跟随 Typecho 设置的时区
setTimezoneByOffset($this->options->timezone);
// 语言初始化
// 获取分类数据
$categoryPostCount = categoryPostCount();
// 文章更新日历数据
$postCalendarData = postCalendar(time() - 20736000, time());
// 评论更新日历数据
$commentCalendarData = commentCalendar(time() - 20736000, time());

$GLOBALS['page'] = 'page-data';
$this->need('components/header.php');
?>

<main class="container main" id="main">
    <div class="row my-4">
        <div class="col-xl-8 col-lg-8 post-page statistics-page mb-5 mb-sm-5 mb-md-5 mb-lg-0 mb-xl-0">
            <?php if ($this->options->breadcrumb == 'on'): ?>
                <nav aria-label="<?php echo '页面路径'; ?>" class="breadcrumb-nav bg">
                    <ol class="breadcrumb m-0 pl-0 pr-0 pt-0 border-0">
                        <li class="breadcrumb-item">
                            <a href="<?php $this->options->siteUrl(); ?>"><?php echo '首页'; ?></a>
                        </li>
                        <li tabindex="0" class="breadcrumb-item active" aria-current="page"><?php $this->title(); ?></li>
                    </ol>
                </nav>
            <?php endif; ?>
            <main class="page">
                <article class="mb-4 border-bottom">
                    <header>
                        <h1 class="post-title m-0">
                            <a href="<?php $this->permalink(); ?>" rel="bookmark"><?php $this->title(); ?></a>
                        </h1>
                    </header>
                    <?php $headerImg = headerImageDisplay($this, $this->options->headerImage, $this->options->headerImageUrl); ?>
                    <?php if ($headerImg): ?>
                        <div class="header-img mb-3 mt-4">
                            <a <?php if ($this->options->headerImageStyle == 'rounded-corners') echo 'class="rounded"'; ?> href="<?php $this->permalink(); ?>" aria-hidden="true" aria-label="文章头图" style="background-image: url(<?php echo $headerImg; ?>);" tabindex="-1"></a>
                        </div>
                    <?php endif; ?>
                    <div class="post-info mt-2">
                        <span class="ml-1" title="<?php echo '发布日期'; ?>" data-toggle="tooltip" data-placement="top">
                            <i class="icon-calendar mr-1" aria-hidden="true"></i>
                            <time datetime="<?php echo date('c', $this->created); ?>"><?php echo postDateFormat($this->created); ?></time>
                        </span>
                        <span class="ml-2" title="<?php echo '作者'; ?>" data-toggle="tooltip" data-placement="top">
                            <i class="icon-user mr-1" aria-hidden="true"></i>
                            <a href="<?php $this->author->permalink(); ?>" class="mr-2" title="作者：<?php $this->author(); ?>">
                                <?php $this->author(); ?>
                            </a>
                        </span>
                        <span class="ml-2" title="<?php echo '阅读量'; ?>" data-toggle="tooltip" data-placement="top">
                            <i class="icon-eye mr-1" aria-hidden="true"></i>
                            <?php echo postViews($this); ?>
                        </span>
                    </div>
                    <div class="post-content mt-4">
                        <h2><?php echo '基本统计'; ?></h2>
                        <p><?php echo '下面是网站的基本数据统计：'; ?></p>
                        <?php Typecho_Widget::widget('Widget_Stat')->to($quantity); ?>
                        <div class="row">
                            <!--文章数-->
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 pb-3">
                                <div class="py-2 statistics-card">
                                    <h3 class="text-center"><?php $quantity->publishedPostsNum(); ?></h3>
                                    <h4 class="text-center"><?php echo '文章数'; ?></h4>
                                </div>
                            </div>
                            <!--评论数-->
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 pb-3">
                                <div class="py-2 statistics-card">
                                    <h3 class="text-center"><?php $quantity->publishedCommentsNum(); ?></h3>
                                    <h4 class="text-center"><?php echo '评论数'; ?></h4>
                                </div>
                            </div>
                            <!--分类数-->
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 pb-3">
                                <div class="py-2 statistics-card">
                                    <h3 class="text-center"><?php echo categoryCount(); ?></h3>
                                    <h4 class="text-center"><?php echo '分类数'; ?></h4>
                                </div>
                            </div>
                            <!--标签数-->
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 pb-3">
                                <div class="py-2 statistics-card">
                                    <h3 class="text-center"><?php echo tagCount(); ?></h3>
                                    <h4 class="text-center"><?php echo '标签数'; ?></h4>
                                </div>
                            </div>
                            <!--文章阅读量-->
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 pb-3">
                                <div class="py-2 statistics-card">
                                    <h3 class="text-center"><?php echo viewsCount(); ?></h3>
                                    <h4 class="text-center"><?php echo '文章阅读量'; ?></h4>
                                </div>
                            </div>
                            <!--获赞数-->
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 pb-3">
                                <div class="py-2 statistics-card">
                                    <h3 class="text-center"><?php echo agreeCount(); ?></h3>
                                    <h4 class="text-center"><?php echo '获赞数'; ?></h4>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!--文章分类占比图-->
                        <h2><?php echo '分类占比'; ?></h2>
                        <?php if (empty($categoryPostCount)): ?>
                            <p><?php echo '目前暂无分类数据！'; ?></p>
                        <?php else: ?>
                            <p><?php echo '下面是每个分类的文章占比：'; ?></p>
                            <div id="category-chart" role="img">
                                <div class="loading text-center">
                                    <h4 class="text-primary"><?php echo '正在加载图表...'; ?></h4>
                                </div>
                            </div>
                        <?php endif; ?>    
                        <hr>
                        <!--文章更新日历图-->
                        <h2><?php echo '文章更新'; ?></h2>
                        <p><?php printf('下面是 %s 到 %s 的文章更新情况', postDateFormat(time() - 20736000), postDateFormat(time())); ?></p>
                        <div id="post-chart" role="img" aria-label="用于显示文章更新动态的日历图">
                            <div class="loading text-center">
                                <h4 class="text-primary"><?php echo '正在加载图表...'; ?></h4>
                            </div>
                        </div>
                        <hr>
                        <!--评论更新日历图-->
                        <h2><?php echo '评论动态'; ?></h2>
                        <p><?php printf('下面是 %s 到 %s 的评论动态', postDateFormat(time() - 20736000), postDateFormat(time())); ?></p>
                        <div id="comment-chart" role="img" aria-label="用于显示评论更新动态的日历图">
                            <div class="loading text-center">
                                <h4 class="text-primary"><?php echo '正在加载图表...'; ?></h4>
                            </div>
                        </div>
                        <hr>
                        <!--按阅读量的文章排名表格-->
                        <h2><?php echo '最多阅读的文章'; ?></h2>
                        <?php $top5Post = top5post(); ?>
                        <?php if (count($top5Post)): ?>
                            <p><?php printf('下面是最多阅读的 %d 篇文章：', count($top5Post)); ?></p>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th><?php echo '排名'; ?></th>
                                        <th><?php echo '标题'; ?></th>
                                        <th><?php echo '阅读量'; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $top = 1; ?>
                                    <?php foreach ($top5Post as $post): ?>
                                        <tr>
                                            <td><?php echo $top; ?></td>
                                            <td><a href="<?php echo $post['link']; ?>"><?php echo $post['title']; ?></a></td>
                                            <td><?php echo $post['views']; ?></td>
                                        </tr>
                                        <?php $top ++; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p><?php echo '目前没有任何文章！'; ?></p>
                        <?php endif; ?>    
                        <hr>
                        <!--按评论数量的文章排名表格-->
                        <h2><?php echo '最多评论的文章'; ?></h2>
                        <?php $top5CommentPost = top5CommentPost(); ?>
                        <?php if (count($top5CommentPost)): ?>
                            <p><?php printf('下面是评论数最多的 %d 篇文章：', count($top5CommentPost)); ?></p>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th><?php echo '排名'; ?></th>
                                        <th><?php echo '标题'; ?></th>
                                        <th><?php echo '评论数'; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $top = 1; ?>
                                    <?php foreach ($top5CommentPost as $post): ?>
                                        <tr>
                                            <td><?php echo $top; ?></td>
                                            <td><a href="<?php echo $post['link']; ?>"><?php echo $post['title']; ?></a></td>
                                            <td><?php echo $post['commentsNum']; ?></td>
                                        </tr>
                                        <?php $top ++; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p><?php echo '目前没有任何文章！'; ?></p>
                        <?php endif; ?>    
                    </div>
                </article>
                <?php $this->need('components/comments.php'); ?>
            </main>
        </div>
        <?php $this->need('components/sidebar.php'); ?>
    </div>
    <script type="text/javascript">
      var data = {
        post: <?php echo json_encode($postCalendarData); ?>,
        comment: <?php echo json_encode($commentCalendarData); ?>,
        category: <?php echo json_encode($categoryPostCount); ?>
      };
      if (data.category.length !== undefined && data.category.length < 1) data.category = undefined;
    </script>
    <?php $id = $this->options->pjax == 'on' ? '?id=' . mt_rand(1, 99999) : ''; ?>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/ECharts.js'); ?><?php echo $id; ?>"></script>
</div>
<?php $this->need('components/footer.php'); ?>
