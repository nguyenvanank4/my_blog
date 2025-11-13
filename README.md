# my_blog_cms (WordPress on XAMPP)

A local WordPress project that includes:
- Custom plugin `featured-posts` providing a `[featured_posts]` shortcode
- Custom theme `myblog-theme` with responsive layout and AJAX “Load More Posts”

## 1) Requirements
- XAMPP (Apache + MySQL) on Windows
- PHP version compatible with your WordPress version

## 2) Setup on XAMPP
1. Start Apache and MySQL from XAMPP Control Panel.
2. Create a database `my_blog_cms_db` in phpMyAdmin (Collation: utf8mb4_unicode_ci).
3. Copy WordPress core files into `my_blog_cms` (keep this repository’s `wp-content` intact).
4. Create `wp-config.php` from `wp-config-sample.php` and configure:
   ```php
   define('DB_NAME', 'my_blog_cms_db');
   define('DB_USER', 'root');
   define('DB_PASSWORD', '');
   define('DB_HOST', 'localhost');
   ```
5. Visit `http://localhost/my_blog/my_blog_cms/` and complete the install wizard.

## 3) Activate Theme and Plugin
In `wp-admin`:
- Appearance → Themes → Activate `myblog-theme`
- Plugins → Installed Plugins → Activate `Featured Posts`

## 4) Using the featured posts shortcode
Insert the shortcode in any page or post content:
```
[featured_posts]
```
Attributes:
- `count` (number, default 3): number of posts to show.
- `category` (string, optional): category slug to filter posts.

Examples:
```
[featured_posts count="5"]
[featured_posts count="5" category="news"]
```

## 5) AJAX “Load More Posts”
The theme’s blog index includes a “Load More Posts” button that loads next pages via AJAX.
- If JavaScript is disabled, standard pagination links will appear as a fallback.

## 6) Screenshots (optional)
- Add your screenshots to a `/screenshots` folder and reference them here:
  - Theme index: ./screenshots/theme-index.png
  - Featured shortcode: ./screenshots/shortcode-featured.png

## 7) Development notes
- Code is commented for beginner readability.
- Security basics: escaping output, nonces for AJAX, sanitized shortcode attributes.
- Version control: `.gitignore` excludes WordPress core and transient folders.


