# Custom Login Logo

> Easily add a custom logo to your WordPress login page using the built-in media uploader — no coding or FTP needed.

Ideal for freelancers, agencies, or anyone looking to personalise the WordPress login experience.

If this plugin helps you, please consider [leaving a 5-star review](https://wordpress.org/support/plugin/custom-login-logo/reviews/?rate=5#new-post) — it supports future updates and helps others discover the plugin.

---

## Features

- Upload a custom login logo using the media uploader
- No coding or FTP required
- Works with most WordPress themes
- Retina/high–DPI image compatible
- Lightweight and fast — no bloat
- One clean settings screen in the admin
- Follows WordPress Coding Standards

---

## Security

If you discover a security issue, please report it responsibly to `mail@webtions.com`.

---

## License

GPL-3.0
See [license details here](https://www.gnu.org/licenses/gpl-3.0.txt)

---

## Development

<details>
<summary><strong>Show setup instructions</strong></summary>

### Clone and Install

```bash
git clone https://github.com/webtions/custom-login-logo.git
cd custom-login-logo
composer install
```

### Useful Commands

**Check for coding standard violations:**

```bash
composer standards:check
```

**Fix fixable code style issues:**

```bash
composer standards:fix
```

**Run static analysis:**

```bash
composer analyze
```

> This plugin follows the official [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/).
</details>

---

## Changelog

<details>
<summary><strong>View changelog</strong></summary>

### 1.2.0 - (29 July 2025)
- Simplified: Removed unnecessary class instantiation and OOP overhead
- Updated: Refactored and modernized code structure
- Updated: Moved JavaScript to assets/js folder and renamed for clarity
- Fixed: Replaced deprecated hook `login_headertitle` with `login_headertext`
- Fixed: Escaping and PHPCS compliance issues across the plugin
- Improved: File and class naming to follow WordPress standards
- Removed: Old/unused files, comments, and legacy patterns

### 1.1.2 - (30 June 2018)
- Added: max-width details below upload field

### 1.1.2 - (27 February 2018)
- Fixed issue on post screen & updated tag

### 1.1.1 - (24 February 2018)
- FIX: Removed a line accidentally added from OOP tutorial causing call_user_func_array error.

### 1.1.0 - (24 February 2018)
- Recoded the entire plugin

### 1.0.2 - (16 February 2014)
- Changed WP_PLUGIN_URL to plugins_url()

### 1.0.1 - (14 December 2013)
- Fixed auto width issue by adding width property.

### 1.0.0 - (26 May 2013)
- This is the first version

</details>
