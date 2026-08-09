/*!\
* HomePage: https://www.misterma.com
* GithubPage: https://github.com/changbin1997
* ProjectPage: https://github.com/changbin1997/Facile
* author: Changbin (changbin1997)
* Licensed under MIT
*/

function Lightbox() {
  this.imgCount = 0;
  this.imgIndex = null;
  this.srcImgSize = {width: 0, height: 0};
  this.imgElSize = {width: 0, height: 0, left: 0, top: 0};
  this.isShow = false;
  this.maxImgSize = {width: 0, height: 0};
  this.allowMove = false;
  this.direction = 0;
  this.imgEl = null;
}
Lightbox.prototype.init = function() {};

function Emoji() {
  this.isShow = false;
  this.emojiList = {};
}
Emoji.prototype.init = function() {};

function ThemeColor() {}
ThemeColor.prototype.init = function() {};

function AvatarGenerator() {}
AvatarGenerator.prototype.refresh = function() {};

function PJAX() {}
PJAX.prototype.init = function(callback) {
  if (callback) callback();
};

function accessibilityInit() {}
function codeHighlightInit() {}

var ArticleEngagement = {
  likeInit: function() {},
  shareQrCode: function() {}
};

$(function () {
  var inputFocus = false;

  // 目录初始化 - 核心功能
  var directory = new Directory();
  directory.init();

  // 图片灯箱初始化
  var lightbox = new Lightbox();
  lightbox.init();

  // Emoji初始化
  var emoji = new Emoji();
  emoji.init();

  // 主题配色初始化
  var themeColor = new ThemeColor();
  themeColor.init();

  // 文字头像样式初始化
  var avatarGenerator = new AvatarGenerator();

  // 给文章中的代码块添加拷贝按钮和拷贝事件
  codeHighlightInit();

  // 点赞初始化
  ArticleEngagement.likeInit();

  // 一些可访问性相关的功能初始化
  accessibilityInit();

  // 生成文章的分享二维码
  ArticleEngagement.shareQrCode();

  // 图片懒加载
  lazyLoadImages();

  // 表单焦点事件初始化
  inputFocusInit();

  // pjax 初始化
  var pjax = new PJAX(function() {
    avatarGenerator.refresh();
    ArticleEngagement.likeInit();
    emoji.init();
    accessibilityInit();
    ArticleEngagement.shareQrCode();
    lazyLoadImages();
    inputFocusInit();
    lightbox.init();
    directory.init();
    themeColor.init();
    codeHighlightInit();
    $('.sidebar .change-language').on('change', changeLanguage);
  });

  // 导航栏的切换语言点击
  $('header .change-language').on('click', changeLanguage);

  // 侧边栏的语言更改
  $('.sidebar .change-language').on('change', changeLanguage);

  // 窗口尺寸改变事件
  window.addEventListener('resize', function() {
    directory.directorySize();
  });

  // 全局快捷键
  $(document).on('keyup', function(ev) {
    if ((ev.keyCode === 39 || ev.key === 'ArrowRight') && !inputFocus && !lightbox.isShow) {
      if ($('.next .page-link').length) {
        $('.next .page-link').get(0).click();
      }
      if ($('.post-pagination .next-page').length) {
        $('.post-pagination .next-page').get(0).click();
      }
    }
    if ((ev.keyCode === 37 || ev.key === 'ArrowLeft') && !inputFocus && !lightbox.isShow) {
      if ($('.prev .page-link').length) {
        $('.prev .page-link').get(0).click();
      }
      if ($('.post-pagination .previous-page').length) {
        $('.post-pagination .previous-page').get(0).click();
      }
    }
  });

  // 页面空白区域点击
  $('body').on('click', function() {
    if (emoji.isShow) $('#show-emoji-btn').click();
  });

  // 评论内容输入框点击
  $('#textarea').on('click', function() {
    return false;
  });

  // 监听滚动条
  $(document).on('scroll', function() {
    if ($('#to-top-btn').length) {
      if ($(document).scrollTop() > window.innerHeight) {
        $('#to-top-btn').removeClass('d-none');
      } else {
        $('#to-top-btn').addClass('d-none');
      }
    }

    $('.load-img').each(function() {
      if (
        $(this).offset().top < $(document).scrollTop() + window.innerHeight &&
        $(this).offset().top + $(this).height() > $(document).scrollTop()
      ) {
        if ($(this).attr('src') === undefined) {
          $(this).attr('src', $(this).attr('data-src'));
        }
      }
    });

    directory.directoryPosition();
  });

  // 返回顶部按钮点击
  $('#to-top-btn').on('click', function() {
    $('html').animate({
      scrollTop: 0
    }, 400);
    $('header .navbar-brand').get(0).focus();
    return false;
  });

  // 图片懒加载
  function lazyLoadImages() {
    $('.load-img').each(function() {
      if ($(this).offset().top < window.innerHeight && $(this).hasClass('load-img')) {
        $(this).attr('src', $(this).attr('data-src'));
      }
    });
    $('.load-img').on('load', function() {
      $(this).removeClass('load-img');
    });
  }

  // 表单焦点事件初始化
  function inputFocusInit() {
    $('input[type="search"], input[type="text"], input[type="email"], input[type="url"], textarea').on('focus', function() {
      inputFocus = true;
    });
    $('input[type="search"], input[type="text"], input[type="email"], input[type="url"], textarea').on('blur', function() {
      inputFocus = false;
    });
  }

  // 更改语言
  function changeLanguage(ev) {
    var language = $(ev.target).attr('data-language');
    var time = Date.parse(new Date());
    time += 15552000000;
    time = new Date(time);
    document.cookie = 'language=' + language + ';path=/;expires=Tue,' + time;
    location.reload();
  }
});
