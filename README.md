# Google Analytics (GA4) Dashboard

Bring **Google Analytics 4** insights into the **Statamic Control Panel**.
This addon provides **actionable tables and charts** so editors can quickly understand what content performs best.

> ⚠️ **Commercial addon**  
> This addon is paid software. You may use it for development and evaluation, but a valid license from the **Statamic Marketplace** is required for production use.

---

## Introduction

**Google Analytics (GA4) Dashboard** is an addon that integrates your site with **Google Analytics 4** using the official GA4 Data API.

This addon does not replace Google Analytics and does not modify any Google services. It acts as a Statamic-specific integration layer that fetches and displays GA4 data inside the Control Panel.

Everything is designed to be fast, readable, and consistent with Statamic CP UI.

The dashboard is designed to give you a quick overview and let you drill down into what matters, directly inside the Control Panel.

## GA4 credentials & setup

This addon does not implement its own Google authentication layer.
To connect your site to Google Analytics 4 you must configure **spatie/laravel-analytics**.

To obtain GA4 API credentials (Google Cloud project, service account, JSON key, and property ID), follow the official Spatie documentation:

- https://github.com/spatie/laravel-analytics

All authentication, API access, and key management are handled by Spatie’s package.
This addon simply uses that configuration to display GA4 data inside Statamic.

---

## Powered by GA4 Data API

Under the hood the addon uses:

- Google Analytics 4 Data API
- `spatie/laravel-analytics`

So you get official GA metrics without scraping or hacks.

## Credits & licensing

This addon is a commercial product developed by **ISAPP**.

It uses the open-source package **spatie/laravel-analytics** (MIT License) to communicate with the Google Analytics 4 Data API.

Google Analytics and GA4 are trademarks of Google LLC. This addon is not affiliated with or endorsed by Google.

---

## Support

If you run into any issues, please open an issue in the repository.
