# GA4 Widgets (spatie/laravel-analytics)

> This addon uses **tables and charts** depending on what is clearest.
> **Exception:** `fetchTotalVisitorsAndPageViews(Period)` is displayed as a **table only** (no chart).

| Status | UI Title | Display Type | Method | Metrics | Dimensions | Filters | Notes |
|---|---|---|---|---|---|---|---|
| ✅ | Top Pages | **Table (Top pages)** | `fetchVisitorsAndPageViews(Period)` | `activeUsers`, `screenPageViews` | `pageTitle` (and/or `fullPageUrl`) | — | Primary content ranking table for the selected period. |
| ✅ | Top Pages (Trend) | **Table (Top pages + Trend bars)** | `fetchVisitorsAndPageViewsByDate(Period)` | `activeUsers`, `screenPageViews` | `pageTitle`, `fullPageUrl`, `date` | — | Top 25 pages with a Trend column (5 normalized bars per page). |
| ✅ | Traffic (Daily totals) | **Table (Daily totals)** | `fetchTotalVisitorsAndPageViews(Period)` | `activeUsers`, `screenPageViews` | `date` | — | Daily totals for the whole site. **Displayed as a table only** (no chart). |
| ✅ | Most Visited Pages | **Table (Ranked)** | `fetchMostVisitedPages(Period, max)` | `screenPageViews` | `pageTitle`, `fullPageUrl` | — | Alternative top-pages list (ranked). |
| ✅ | Top Referrers | **Table (Ranked)** | `fetchTopReferrers(Period, max)` | `screenPageViews` | `sessionSource` / referrer | — | Where traffic comes from. |
| ✅ | New vs Returning Users | **Donut + Table (Breakdown)** | `fetchUserTypes(Period)` | `activeUsers` | `newVsReturning` | — | Audience split by user type. |
| ✅ | Top Browsers | **Table (Ranked)** | `fetchTopBrowsers(Period, max)` | `screenPageViews` | `browser` | — | Technical audience profile. |
| ✅ | Top Countries | **Table (Ranked)** | `fetchTopCountries(Period, max)` | `screenPageViews` | `country` | — | Geographic distribution. |
| ✅ | Operating Systems | **Table (Ranked)** | `fetchTopOperatingSystems(Period, max)` | `screenPageViews` | `operatingSystem` | — | Device OS breakdown. |
| ⬜ | Custom Report | **Custom (Builder)** | `get(Period, metrics, dimensions, ...)` | any | any | optional | Generic GA4 query builder (metrics/dimensions, filters, order, limits). |


## GA4 Widgets (Not covered by spatie methods)

| Status | UI Title | Display Type | Method | Metrics | Dimensions | Filters | Notes |
|---|---|---|---|---|---|---|---|
| ⬜ | Realtime Users | **Realtime cards / table** | `get()` (realtime) | `activeUsers` | `pagePath`, `eventName` | realtime scope | Live users, pages and events right now. |
| ⬜ | Landing Pages | **Table (Ranked)** | `get()` | `sessions`, `activeUsers`, `engagementRate` | `landingPage` | — | Entry pages where sessions start. GA → Reports → Landing pages. |
| ⬜ | Exit Pages | **Table (Ranked)** | `get()` | `sessions` | `exitPage` | — | Pages where users leave the site. |
| ⬜ | Site Search | **Table (Ranked)** | `get()` | `eventCount` | `searchTerm` | `eventName = search` | What users search on the site. |
| ⬜ | Zero-result Searches | **Table (Ranked)** | `get()` | `eventCount` | `searchTerm` | `eventName = search` AND `searchResults = 0` | Queries that returned no results. |
| ⬜ | Page Engagement | **Table (Ranked)** | `get()` | `averageSessionDuration`, `engagementRate` | `pagePath` | — | How engaging each page is. |
| ⬜ | Conversion Paths | **Table (Ranked)** | `get()` | `eventCount` | `pagePath` | `isKeyEvent = true` | Pages that lead to conversions. |
| ⬜ | Time of Day | **Bar chart + Table** | `get()` | `activeUsers` | `hour` | — | When users are most active during the day. |
| ⬜ | Cities | **Table (Ranked)** | `get()` | `screenPageViews` | `city` | — | Traffic by city (more granular than countries). |
| ⬜ | Content Growth / Decline | **Table (Δ comparison)** | `get()` | `screenPageViews` | `pagePath` | compare two periods | Biggest winners & losers vs previous period. |