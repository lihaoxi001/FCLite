# AGENTS.md - Facile Theme for Typecho

## Project Overview

Facile is a clean, responsive Typecho blog theme written in PHP with vanilla JavaScript and CSS. It supports light/dark themes, code highlighting, PJAX, and accessibility.

## Directory Structure

```
facile/
├── functions.php          # Theme entry, loads inc/ modules
├── index.php              # Homepage template
├── post.php               # Single post template
├── page.php               # Page template
├── archive.php            # Archive/category/tag listing
├── 404.php                # 404 error page
├── page-*.php             # Custom page templates (links, archive, data)
├── inc/                   # PHP helper modules
│   ├── theme-config.php   # Admin panel configuration form
│   ├── theme-fields.php   # Per-post custom fields
│   └── helpers.php        # Utility functions (900+ lines)
├── components/            # Reusable template partials
│   ├── header.php         # HTML head, navbar
│   ├── footer.php         # Footer, scripts
│   ├── sidebar.php        # Sidebar widgets
│   ├── post-list.php      # Post list rendering
│   ├── comments.php       # Comment section
│   ├── comment-input.php  # Comment form
│   └── link-editor.php    # Admin link editor UI
├── assets/
│   ├── css/
│   │   ├── style-*.css    # Main theme CSS (bundled, cache-busted filename)
│   │   └── options-panel.css  # Admin panel styles (raw)
│   └── js/
│       ├── bundle-*.js    # Main JS bundle (Webpack: jQuery + Bootstrap + highlight.js + PJAX + Popper + custom code)
│       ├── ECharts.js     # Bundled ECharts charts (pie + calendar only)
│       └── options-panel.js   # Admin panel JS (raw ES6)
└── languages/
    └── zh.php             # Chinese translations
```

## Build / Lint / Test Commands

**There are no build, lint, or test tools in this repository.**

- No `package.json`, no `webpack.config.js`, no ESLint, no PHP linter config
- The JS bundle (`bundle-*.js`) is pre-compiled and committed; source files are not in this repo
- CSS (`style-*.css`) is also pre-compiled and committed
- Development workflow: edit PHP/CSS/JS files directly, then deploy to Typecho

### Manual verification

```bash
# PHP syntax check (run on any PHP file)
php -l functions.php
php -l inc/helpers.php

# To lint PHP manually (if phpstan/php-cs-fixer installed globally)
php -l *.php inc/*.php components/*.php
```

## Code Style & Conventions

### PHP

- **Opening tag**: Always `<?php` (no short tags). Every template file starts with `if (!defined('__TYPECHO_ROOT_DIR__')) exit;`
- **Indentation**: 4 spaces (no tabs)
- **Braces**: K&R style — opening brace on same line for functions/control structures
- **Naming**:
  - Functions: `camelCase` (e.g., `languageInit`, `agreeNum`, `postDateFormat`)
  - Variables: `camelCase` (e.g., `$headerImg`, `$engagementSection`)
  - Global state: `$GLOBALS['t']` for translations, `$GLOBALS['page']` for current page, `$GLOBALS['color']` for theme color, `$GLOBALS['directory']` for article TOC
- **Comments**: PHPDoc blocks above functions with `@param`, `@return`, and Chinese descriptions
- **String concatenation**: Use `.` operator with spaces around it
- **Arrays**: Use `array()` syntax (not `[]`) for broader PHP compatibility
- **Error handling**: Silent catches (`catch (Exception $e) {}`) in non-critical paths like `checkField()`
- **Database queries**: Use Typecho's query builder (`$db->select()`, `$db->update()`, etc.)
- **Output escaping**: Use `echo` with `$GLOBALS['t']` for all user-facing text; HTML attributes use `<?php echo ... ?>` or `<?php $var(); ?>` shorthand

### HTML/Template

- **Indentation**: 4 spaces
- **Accessibility**: Extensive ARIA attributes (`aria-label`, `aria-current`, `aria-expanded`, `role`, `tabindex`)
- **Bootstrap 4**: Uses Bootstrap 4 utility classes (`mt-4`, `mb-3`, `col-xl-8`, `text-center`, etc.)
- **Language**: Template text uses `$GLOBALS['t']` translation arrays, never hardcoded strings
- **Control structures**: Use PHP alternative syntax (`if (): ... endif;`, `foreach (): ... endforeach;`, `while (): ... endwhile;`)

### JavaScript

- **`options-panel.js`**: Raw ES6 (arrow functions, `const`/`let`, template literals). No bundler; embedded directly via `require_once` in admin panel
- **`bundle-*.js`**: Pre-bundled Webpack output (minified). Do not edit directly
- **`ECharts.js`**: Pre-bundled Webpack output (minified). Do not edit directly
- **Style**: The source JS (options-panel.js) uses:
  - 2-space indentation
  - `const`/`let` (no `var`)
  - Arrow functions
  - Template literals
  - Semicolons at end of statements
- **jQuery**: Available as `$` globally in the bundle
- **i18n**: All text is in Chinese.

### CSS

- **`style-*.css`**: Pre-bundled, minified. Do not edit directly
- **`options-panel.css`**: Raw CSS, 2-space indentation
- **Custom CSS**: Users can add custom CSS via the theme settings panel (`cssCode` option)

### Naming Conventions

| Element | Convention | Example |
|---------|-----------|---------|
| PHP functions | camelCase | `languageInit()`, `agreeNum()` |
| PHP variables | camelCase | `$headerImg`, `$agreeRecording` |
| PHP globals | `$GLOBALS['key']` | `$GLOBALS['t']`, `$GLOBALS['page']` |
| Custom fields | camelCase | `headerImgDisplay`, `imageSource` |
| Config options | camelCase | `codeHighlight`, `imagelazyloading` |
| Language keys | camelCase (long descriptive) | `pressEnterToAddTheEmojiToTheCommentInputField` |

## Key Patterns

1. **Translation system**: `$GLOBALS['t']` holds translation arrays from `languages/zh.php`. All UI text uses this — never hardcode display strings in templates.
2. **Theme config**: `themeConfig()` in `inc/theme-config.php` defines all admin panel options via `Typecho_Widget_Helper_Form_Element_*` helpers.
3. **Per-post fields**: `themeFields()` in `inc/theme-fields.php` defines custom fields available when editing individual posts.
4. **Helper functions**: `inc/helpers.php` contains all utility functions — DB queries, date formatting, image handling, pagination, article TOC generation.
5. **Template includes**: Use `$this->need('components/partial.php')` to include template partials.
6. **Cookie-based state**: Theme color, language, and like-recording are stored in cookies.

## Dependencies (Runtime)

- **Typecho** (the CMS this theme runs on)
- **jQuery 3.4.1** (bundled)
- **Bootstrap 4.4.1** (bundled)
- **highlight.js** (bundled, 30+ languages)
- **Popper.js 1.16.1** (bundled)
- **jquery-pjax** (bundled)
- **qrious** (QR code generation, bundled)
- **ECharts** (bundled, pie + calendar charts only)
