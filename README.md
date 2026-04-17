# FCLite — 高性能 Typecho 博客主题

FCLite 是基于 [Facile 2.5](https://github.com/changbin1997/Facile) 的深度修改版本，专注于**网页加载速度优化**和**简洁设计**。

## ⚡ 性能优化

经过系统性的性能调优，FCLite 在 PageSpeed Insights 上表现出色：

| 指标 | 桌面端 | 移动端 |
|------|--------|--------|
| 性能得分 | **100** | **97** |
| 首次内容绘制 (FCP) | < 0.5s | 2.0s |
| 最大内容绘制 (LCP) | < 0.8s | 2.1s |
| 累积布局偏移 (CLS) | **0** | **0** |
| 总阻塞时间 (TBT) | 0ms | 0ms |

### 具体优化措施

- **清理未使用的 CSS**：移除了 Bootstrap 中未使用的组件（modal、carousel、tooltip、popover、dropdown 等），CSS 体积减少 **40KB+**
- **零布局偏移**：CSS 同步加载，避免延迟加载导致的页面跳动，CLS = 0
- **WebP 缩略图自动压缩**：列表页封面图自动生成 160×90 WebP 缩略图，典型压缩率 **95%+**（1.8MB PNG → 31KB WebP）
- **轻量首屏**：首页完整加载仅 **688KB**（gzip），其中图片仅 22KB

### 首页资源分布

| 类型 | 大小 (gzip) | 占比 |
|------|------------|------|
| CSS | ~250KB | 36% |
| JS | ~309KB | 45% |
| 图片 | ~22KB | 3% |
| HTML | ~34KB | 5% |

## 🚀 主要修改内容

- ⚡ **WebP 缩略图自动压缩**：列表页封面图自动生成 WebP 缩略图，大幅加快列表页加载速度
- 🃏 **卡片式列表**：将文章列表改为卡片式设计，提升视觉效果和阅读体验
- 🎨 **优化主题配色**：采用简洁的黑白灰配色方案，超链接保持蓝色
- 🗑️ **精简 CSS**：移除未使用的 Bootstrap 组件，减小渲染阻塞体积
- 🖼️ **固定小图头图样式**：文章列表头图固定为小图模式，移除了大头图样式选项及相关代码
- 🗑️ **删除语言切换功能**：移除了多语言支持，主题固定使用中文显示

## 特点和功能

* 响应式设计
* 无障碍适配（Accessibility）
* 包含浅色和深色两套配色（可根据系统主题配色自动调节）
* 代码高亮
* 自带点赞功能
* 支持根据文章内插入的标题生成章节目录
* 支持图片懒加载
* 列表页自动 WebP 缩略图压缩（95%+ 压缩率）
* 支持文章分页
* 文章列表支持多种排版方式
* 丰富的侧边栏组件
* 丰富的设置选项
* 详细的图表统计
* 评论区自带 Emoji 表情面板
* 支持 PJAX 无刷新跳转

## 安装

在 [Releases](https://github.com/lihaoxi001/FCLite/releases) 下载最新版本的 zip 压缩包，上传到 Typecho 目录下的 `usr/themes/` 目录，解压后可以看到 `FCLite` 目录。

登录 Typecho 后台，在 `控制台` → `外观` 中启用 FCLite 主题。

## WebP 缩略图特性

- **自动裁剪**：对头图进行居中裁剪，生成统一风格的缩略图
- **智能缓存**：缩略图缓存在主题目录 `assets/cache/thumbs/` 内，删除主题即清除缓存，零残留
- **按需生成**：首次访问时自动生成，后续直接读取缓存，不影响响应速度
- **仅列表页生效**：文章详情页仍显示原图，不影响阅读体验
- **环境要求**：PHP 7.0+，需安装 GD 扩展并启用 WebP 支持

## 主题依赖

* [Bootswatch](https://github.com/thomaspark/bootswatch) — Bootstrap 主题
* [jQuery](https://jquery.com/) — DOM 操作
* [qrious](https://github.com/neocotic/qrious) — 二维码生成
* [highlight.js](https://highlightjs.org/) — 代码高亮
* [ECharts](https://github.com/apache/echarts) — 统计图表
* [jquery-pjax](https://github.com/defunkt/jquery-pjax) — PJAX 无刷新跳转

## 代码高亮

包含三套主题配色：Stack Overflow（浅色）、VS2015（深色）、Sunburst（高对比度），支持 30 多种语言。

## 侧边栏

* 博客信息
* 最新文章
* 最新回复
* 文章分类
* 标签云
* 文章归档
* 其它功能
* 友情链接
* 文章的章节目录
* 自定义

每个组件都可以开启或关闭，支持自定义排序。

## 原主题

原主题下载地址：[https://github.com/changbin1997/Facile/releases](https://github.com/changbin1997/Facile/releases)

原主题使用帮助：[https://facile.misterma.com/](https://facile.misterma.com/)
