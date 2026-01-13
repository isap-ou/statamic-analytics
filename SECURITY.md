# Security Policy

## Supported Versions

We actively maintain security updates for the following versions:

| Addon version | Statamic version | Supported |
| --- | --- | --- |
| 6.x | 6.x | ✅ |
| 5.x | 5.x | ✅ |
| < 5.0 | 4.x and below | ❌ |

## Reporting a Vulnerability

If you discover a security issue, please follow responsible disclosure.

**Please do not report security issues in public GitHub issues.**

### Report via GitHub Security Advisory (preferred)

1. Go to the repository **Security** tab.
2. Click **Report a vulnerability**.
3. Include:
    - Description of the vulnerability
    - Affected versions
    - Steps to reproduce (or a minimal proof of concept)
    - Potential impact
    - Any suggested mitigation (optional)

## Response Timeline

- **Acknowledgement:** within 48 hours
- **Initial assessment:** within 5 business days
- **Fix:** we aim to release a patch as soon as possible (prioritised by severity)

## Scope

This policy covers vulnerabilities in the **statamic-analytics** addon, including:

- Control Panel widgets and data handling
- Configuration and credential management
- Integration points with Statamic

This policy does **not** cover vulnerabilities in upstream dependencies. Please report those to the appropriate maintainers:

- Statamic core: [github.com/statamic/cms/security](https://github.com/statamic/cms/security)
- Laravel framework: [github.com/laravel/framework/security](https://github.com/laravel/framework/security)
- spatie/laravel-analytics: [github.com/spatie/laravel-analytics/security](https://github.com/spatie/laravel-analytics/security)
- Google APIs / Google Analytics: [bughunters.google.com](https://bughunters.google.com/)

## Security Best Practices

- Keep your Google Analytics service account credentials secure
- Never commit credentials to version control
- Use HTTPS in production
- Regularly update Statamic and this addon