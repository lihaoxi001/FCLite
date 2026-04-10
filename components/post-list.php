<?php

$postIndex = 0;
while ($this->next()):
$postIndex++;
?>
<div class="post-card">
    <?php $postListStyle = postListStyle($this->options->postListStyle, $this->fields->postListStyle); ?>
    <!--文章头图区域-->
    <?php $headerImage = headerImageDisplay($this, $this->options->headerImage, $this->options->headerImageUrl); ?>
    <div class="card-body">
        <a href="<?php $this->permalink(); ?>" class="card-link" aria-label="<?php $this->title(); ?>"></a>
        <header>
            <h2 class="card-title">
                <?php $this->sticky(); ?>
                <?php
                if ($this->hidden) {
                    echo $GLOBALS['t']['post']['thisPostIsPasswordProtected'];
                }else {
                    $this->title();
                }
                ?>
            </h2>
            <div class="card-meta mt-2">
                <span title="<?php echo $GLOBALS['t']['post']['publicationDate']; ?>" data-toggle="tooltip" data-placement="top">
                    <i class="icon-calendar mr-1" aria-hidden="true"></i>
                    <time datetime="<?php echo date('c', $this->created); ?>"><?php echo postDateFormat($this->created); ?></time>
                </span>
                <span class="ml-2" title="<?php echo $GLOBALS['t']['post']['author']; ?>" data-toggle="tooltip" data-placement="top">
                    <i class="icon-user mr-1" aria-hidden="true"></i>
                    <a href="<?php $this->author->permalink(); ?>" title="<?php echo $GLOBALS['t']['post']['author']; ?>: <?php $this->author(); ?>">
                        <?php $this->author(); ?>
                    </a>
                </span>
                <span class="ml-2" title="<?php echo $GLOBALS['t']['post']['views']; ?>" data-toggle="tooltip" data-placement="top">
                    <i class="icon-eye mr-1"></i>
                    <?php echo postViews($this); ?>
                </span>
                <span class="ml-2">
                    <a href="<?php $this->permalink() ?>#comments">
                        <i class="icon-bubble mr-1"></i>
                        <?php $this->commentsNum('%d'); ?>
                    </a>
                </span>
            </div>
        </header>
        <?php if ($postListStyle == 'summary'): ?>
            <?php if ($headerImage): ?>
                <div class="card-row mt-3">
                    <div class="content-box">
                        <div class="card-summary">
                            <p class="text-color">
                                <?php
                                if ($this->hidden) {
                                    echo $GLOBALS['t']['post']['enterThePasswordToViewIt'];
                                }else {
                                    $this->fields->summaryContent ? $this->fields->summaryContent() : $this->excerpt($this->options->summary, '...');
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="mini-thumb"><img src="<?php echo $headerImage; ?>" alt="<?php $this->title(); ?>" width="180" height="120" <?php echo $postIndex > 1 ? 'loading="lazy"' : 'fetchpriority="high"'; ?> decoding="async"></div>
                </div>
            <?php else: ?>
                <div class="card-summary mt-3">
                    <p class="text-color">
                        <?php
                        if ($this->hidden) {
                            echo $GLOBALS['t']['post']['enterThePasswordToViewIt'];
                        }else {
                            $this->fields->summaryContent ? $this->fields->summaryContent() : $this->excerpt($this->options->summary, '...');
                        }
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="card-summary mt-3">
                <div class="fullText"><?php echo addBootstrapTableClasses($this->content); ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endwhile; ?>
