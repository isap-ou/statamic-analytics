# Google Analytics (GA4) Dashboard

Transform your Statamic Control Panel into a powerful analytics hub. Monitor your site's performance, understand your audience, and make data-driven content decisions without leaving your CMS.

![Statamic 5.0+](https://img.shields.io/badge/Statamic-5.0+-FF269E?style=for-the-badge&link=https://statamic.com)
[![License](https://img.shields.io/badge/license-Commercial-important?style=for-the-badge)](./LICENSE.md)
[![Latest Version](https://img.shields.io/github/v/release/isap-ou/statamic-analytics?style=for-the-badge)](https://github.com/isap-ou/statamic-analytics/releases)
[![Packagist Downloads](https://img.shields.io/packagist/dt/isapp/statamic-analytics?style=for-the-badge)](https://packagist.org/packages/isapp/statamic-analytics)
> **Commercial Addon**  
> This is paid software. You may use it for development and evaluation, but a valid license from the Statamic Marketplace is required for production use.

---

## Why This Addon?

Content creators and editors shouldn't need to switch between multiple tools to understand what's working. This addon brings Google Analytics 4 data directly into the Statamic Control Panel, giving your team instant access to the metrics that matter.

**Perfect for:**
- Content teams who need quick performance insights
- Editors wanting to see which pages drive the most engagement
- Site managers tracking traffic trends at a glance
- Agencies managing multiple Statamic sites with GA4

---

## Key Features

### 📊 **Dashboard Widgets**
Beautiful, customizable widgets display your most important GA4 metrics right on the Control Panel dashboard. Get instant visibility into:
- Top performing pages and posts
- Traffic sources and channels
- User demographics and device breakdowns
- Custom date range comparisons

### 📈 **Actionable Tables & Charts**
Data is presented in clean, readable formats. Tables are sortable, filterable, and export-ready. Charts update dynamically and respond to your selected date ranges.

### ⚡ **Fast & Efficient**
Built on the official Google Analytics 4 Data API via the trusted `spatie/laravel-analytics` package. Data is fetched efficiently with smart caching to keep your Control Panel responsive.

### 🎨 **Native Statamic UI**
Every widget and view is designed to feel like a natural part of Statamic. Consistent styling, familiar interactions, and seamless integration with your existing Control Panel experience.

### 🔐 **Secure Integration**
Uses Google Cloud service account authentication for secure, server-to-server API access. No OAuth prompts, no user permissions headaches—just reliable data flow.

---

## What You Get

This addon provides several pre-built widgets and views:

- **Visitor Overview** – Total users, sessions, pageviews, and engagement metrics
- **Top Pages** – Your most visited content with bounce rates and time on page
- **Traffic Sources** – Where your visitors come from (organic, direct, social, referral)
- **Geographic Insights** – Top countries and cities for your audience
- **Device & Browser Stats** – Desktop vs mobile breakdown, browser usage
- **Custom Date Ranges** – Compare any time period to understand trends

All widgets are configurable through the addon settings interface. Choose which metrics to display, set default date ranges, and customize the charts to suit your workflow.

---

## Installation

Install via Composer:

```bash
composer require isap-ou/statamic-analytics
```

---

## Configuration

### 1. Set Up Google Analytics 4 API Access

This addon uses the `spatie/laravel-analytics` package to connect to GA4. You'll need:

1. A Google Cloud project
2. A service account with Analytics API access
3. A JSON credentials file
4. Your GA4 Property ID

**Detailed setup instructions:**  
Follow the official Spatie documentation to generate your credentials:  
👉 [spatie/laravel-analytics setup guide](https://github.com/spatie/laravel-analytics)

### 2. Configure Your Environment

Add these to your `.env` file:

```env
ANALYTICS_PROPERTY_ID=your-ga4-property-id
ANALYTICS_SERVICE_ACCOUNT_CREDENTIALS_JSON=/path/to/your-credentials.json
```

### 3. Add Widgets to Your Control Panel

There are two ways to add GA4 widgets to your dashboard:

#### Option A: Using the Control Panel (Recommended)

1. Navigate to your **Control Panel**
2. Go to **Preferences → Widgets**
3. Click **Add Widget**
4. Select the GA4 widgets you want to display
5. Configure widget settings and save

#### Option B: Manual Configuration via `cp.php`

Edit your `config/statamic/cp.php` file and add widgets to the `widgets` array:

```php
'widgets' => [
    'google_analytics',
    // Add more widgets as needed
],
```


### 4. Configure Widget Settings

Navigate to **Control Panel → Settings → Analytics Settings** to customize:
- Property ID (by default it get from config)
- Default date ranges for widgets
- Metrics to display

---

## Usage

Once configured, your GA4 data will automatically populate in the Control Panel.

### Quick Start Tips

**For Content Editors:**
- Check the Top Pages widget to see which content resonates with your audience
- Monitor traffic sources to understand where to focus your promotional efforts
- Use date comparisons to spot trending topics

**For Site Managers:**
- Review geographic data to optimize content localization
- Analyze device breakdowns to prioritize mobile vs desktop UX improvements
- Track campaign performance through traffic source widgets

**For Agencies:**
- Configure different widgets per client site
- Export data tables for client reports
- Use cached data to minimize API quota usage

---

## Requirements

- Statamic 5.0 or higher
- PHP 8.1 or higher
- Laravel 10.0 or higher
- A Google Analytics 4 property
- Google Cloud service account with Analytics API enabled

---

## Technical Details

### Built On Trusted Technology

This addon leverages proven, open-source packages:

- **spatie/laravel-analytics** (MIT License) – Reliable GA4 API integration used by thousands of Laravel applications
- **Google Analytics 4 Data API** – Official Google API for programmatic data access

### No Data Storage

This addon does not store, manipulate, or intercept your analytics data. It acts purely as a display layer, fetching data from Google's servers and presenting it within Statamic.

### Performance Optimized

- Smart caching reduces API calls and speeds up dashboard loading
- Configurable cache durations let you balance freshness with performance
- Lazy-loaded widgets prevent blocking the Control Panel UI

---

## Frequently Asked Questions

**Q: Does this replace Google Analytics?**  
A: No. This addon displays data from your existing GA4 property inside Statamic. You still need a GA4 account and tracking code on your site.

**Q: Will this slow down my Control Panel?**  
A: No. Widgets load asynchronously and use caching. Most data requests happen in the background.

**Q: Can I customize which metrics are shown?**  
A: Yes. Use the settings interface in the Control Panel to configure which metrics and charts appear in your widgets.

**Q: Do I need to be a developer to set this up?**  
A: Basic technical knowledge is helpful for the initial Google Cloud setup, but once configured, it's entirely editor-friendly.

**Q: Does this work with Universal Analytics (UA)?**  
A: No. This addon is built specifically for Google Analytics 4. UA has been deprecated by Google.

**Q: Can multiple users see the dashboard?**  
A: Yes. Once configured, Control Panel users can view the GA4 widgets on their dashboards.

**Q: Does this show real-time data?**  
A: Real-time visitor tracking is planned for a future version. Currently, the addon displays historical and recent data with configurable time ranges.

---

## Support & Documentation

**Need help?**  
Open an issue on the [GitHub repository](https://github.com/isap-ou/statamic-analytics) for bug reports or feature requests.

**Setup assistance:**  
Refer to the [spatie/laravel-analytics documentation](https://github.com/spatie/laravel-analytics) for GA4 API credential setup.

**Updates & changelog:**  
Follow the repository for version updates and new features.

---

## Credits & Licensing

Developed by **ISAPP** as a commercial Statamic addon.

**Built with:**
- [spatie/laravel-analytics](https://github.com/spatie/laravel-analytics) (MIT License)
- Google Analytics 4 Data API

Google Analytics and GA4 are trademarks of Google LLC. This addon is not affiliated with or endorsed by Google.

---

## Roadmap

Planned features for future releases:

- **Real-time visitor tracking** – Monitor active users on your site in real-time
- Custom metric builder for advanced users
- Comparison mode (period over period)
- Scheduled email reports
- Event tracking visualization
- E-commerce metrics (for GA4 Enhanced Ecommerce)
- User permissions for viewing and editing settings

Have a feature request? Let us know on GitHub!

---

## License

This is commercial software. Purchase a license from the Statamic Marketplace to use in production.

**License tiers:**
- Single site license
- Multi-site license
- Developer license (for agencies)

See the [Statamic Marketplace](https://statamic.com/marketplace) for current pricing.

---

**Ready to bring analytics into your Control Panel?**  
[Get Started →](#installation)