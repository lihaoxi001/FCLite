<?php

$postIndex = 0;
while ($this->next()):
$postIndex++;
$headerImage = headerImageDisplay($this, $this->options->headerImage, $this->options->headerImageUrl);
?>
<div class="post-card<?php echo !$headerImage ? ' no-thumb' : ''; ?>">
    <?php $postListStyle = postListStyle($this->options->postListStyle, $this->fields->postListStyle); ?>
    <div class="card-body">
        <a href="<?php $this->permalink(); ?>" class="card-link" aria-label="<?php $this->title(); ?>"></a>
        <?php if ($headerImage): ?>
        <div class="card-thumb">
            <img src="<?php echo $headerImage; ?>" alt="<?php $this->title(); ?>" width="160" height="100" <?php echo $postIndex > 1 ? 'loading="lazy"' : 'fetchpriority="high"'; ?> decoding="async">
        </div>
        <?php endif; ?>
        <div class="card-info">
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
            <span class="card-date"><?php echo date('Y.n.j', $this->created); ?></span>
        </div>
    </div>
</div>
<?php endwhile; ?>
