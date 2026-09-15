<?php if($this->allow('comment')): ?>

<div id="<?php $this->respondId(); ?>" class="comment-input">
    <h2><?php echo '发表评论'; ?></h2>
    <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
        <div class="row">
            <div class="col-12">
                <label for="textarea" class="d-block">
                    <?php echo '评论内容'; ?>
                    <span class="required">*</span>
                </label>
                <textarea name="text" id="textarea" placeholder="<?php echo '请在此处输入评论内容'; ?>" class="form-control" required></textarea>
            </div>
            <!--Emoji表情区域-->
            <?php if ($this->options->emojiPanel == 'show'): ?>
            <div class="col-12" id="emoji-box">
                <button aria-expanded="false" type="button" class="btn btn-sm" id="show-emoji-btn">
                    😀 <?php echo 'Emoji表情'; ?>
                </button>
                <div id="emoji-panel" class="bg-light border shadow rounded" role="dialog" aria-label="<?php echo 'Emoji表情面板（按 ESC 可关闭表情面板并转到评论内容输入框。）'; ?>">
                    <div class="card card-body p-0 m-0 border-bottom">
                        <div id="emoji-classification" class="m-0 btn-group" role="group" aria-label="<?php echo '表情类型'; ?>">
                            <button role="radio" aria-checked="true" aria-label="<?php echo '面部表情'; ?>" title="<?php echo '面部表情'; ?>" type="button" class="btn btn btn-sm selected" data-classification="smileys">😀</button>
                            <button role="radio" aria-checked="false" aria-label="<?php echo '人物/手势'; ?>" title="<?php echo '人物/手势'; ?>" type="button" class="btn btn btn-sm" data-classification="character">👦</button>
                            <button role="radio" aria-checked="false" aria-label="<?php echo '服装/配饰'; ?>" title="<?php echo '服装/配饰'; ?>" type="button" class="btn btn btn-sm" data-classification="clothing">👕</button>
                            <button role="radio" aria-checked="false" aria-label="<?php echo '动物/自然'; ?>" title="<?php echo '动物/自然'; ?>" type="button" class="btn btn btn-sm" data-classification="animal">🐶</button>
                            <button role="radio" aria-checked="false" aria-label="<?php echo '食物'; ?>" title="<?php echo '食物'; ?>" type="button" class="btn btn btn-sm" data-classification="food">🍏</button>
                            <button role="radio" aria-checked="false" aria-label="<?php echo '运动'; ?>" title="<?php echo '运动'; ?>" type="button" class="btn btn btn-sm" data-classification="motion">⚽</button>
                            <button role="radio" aria-checked="false" aria-label="<?php echo '旅行/地点'; ?>" title="<?php echo '旅行/地点'; ?>" type="button" class="btn btn-sm" data-classification="tourism">🚚</button>
                            <button role="radio" aria-checked="false" aria-label="<?php echo '物体'; ?>" title="<?php echo '物体'; ?>" type="button" class="btn btn-sm" data-classification="objects">⌚</button>
                            <button role="radio" aria-checked="false" aria-label="<?php echo '符号'; ?>" title="<?php echo '符号'; ?>" type="button" class="btn btn-sm" data-classification="symbols">❤</button>
                        </div>
                    </div>
                    <h5 class="text-center py-2 m-0 border-bottom" id="emoji-title">表情类型</h5>
                    <div id="emoji-list" class="clearfix" role="list" aria-label="<?php echo '表情列表' . '（按回车可以把表情添加到评论内容输入框）'; ?>"></div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($this->user->hasLogin()): ?>
                <div class="col-lg-12 comment-user">
                    <?php echo '登录身份: '; ?>
                    <a href="<?php $this->options->profileUrl(); ?>" title="当前登录身份：<?php $this->user->screenName(); ?>">
                        <?php $this->user->screenName(); ?>
                    </a>.
                    <a href="<?php $this->options->logoutUrl(); ?>" title="<?php echo '退出登录'; ?>"><?php echo '退出登录'; ?> &raquo;</a>
                </div>
            <?php else: ?>
                <!--姓名输入-->
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label for="author" class="d-block">
                        <?php echo '称呼'; ?>
                        <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control" placeholder="<?php echo '请输入您的姓名或昵称'; ?>" name="author" id="author" value="<?php $this->remember('author'); ?>" required>
                </div>
                <!--邮箱地址输入-->
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label for="mail" class="d-block">
                        <?php echo '电子邮件地址'; ?>
                        <?php if ($this->options->commentsRequireMail): ?>
                            <span class="required">*</span>
                        <?php endif; ?>
                    </label>
                    <input type="email" class="form-control" placeholder="<?php echo '请输入您的电子邮件地址（不会公开）'; ?>" name="mail" id="mail" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail) echo 'required'; ?>>
                </div>
                <!--网站地址输入-->
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label for="url" class="d-block">
                        <?php echo '网站'; ?>
                        <?php if ($this->options->commentsRequireURL): ?>
                            <span class="required">*</span>
                        <?php endif; ?>
                    </label>
                    <input type="url" class="form-control" placeholder="<?php echo '请输入您的网站或博客地址'; ?>" name="url" id="url" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL) echo 'required'; ?>>
                </div>
            <?php endif; ?>
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><?php echo '提交评论'; ?></button>
                <?php $comments->cancelReply(); ?>
            </div>
        </div>
    </form>
</div>

<?php else: ?>
    <div class="comment-off">
        <h2>评论功能已关闭</h2>
    </div>
<?php endif; ?>