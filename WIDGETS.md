# GA4 Widgets (spatie/laravel-analytics)

> Default visualization for time‑series is **Line chart** (as chosen).

| Method | Display Type | UI Title | Description |
|---|---|---|---|
| `fetchVisitorsAndPageViews(Period)` | **Table (Top pages)** | Top Pages (Engagement) | Pages with `pageTitle`, `screenPageViews`, `activeUsers` for the period. Good for ranking content by engagement. |
| `fetchVisitorsAndPageViewsByDate(Period)` | **Line chart** | Users & Page Views Over Time | Time‑series of `activeUsers` and `screenPageViews` by date. Use for trend analysis. |
| `fetchTotalVisitorsAndPageViews(Period)` | **Line chart + KPI** | Traffic Overview | Returns daily rows; render as a line chart and aggregate to show total KPIs (sum of users & views) for the period. |
| `fetchMostVisitedPages(Period, max)` | **Table (Ranked)** | Most Visited Pages | Top pages with `fullPageUrl`, `pageTitle`, `screenPageViews`. Primary content performance list. |
| `fetchTopReferrers(Period, max)` | **Table (Ranked)** | Top Referrers | Referrer URLs/domains with `screenPageViews`. Shows where traffic comes from. |
| `fetchUserTypes(Period)` | **Donut / Breakdown** | New vs Returning Users | `newVsReturning` with `activeUsers`. New vs returning audience split. |
| `fetchTopBrowsers(Period, max)` | **Bar / Table** | Top Browsers | Browsers with `screenPageViews`. Technical audience profile. |
| `fetchTopCountries(Period, max)` | **Bar / Table** | Top Countries | Countries with `screenPageViews`. Geographic distribution. |
| `fetchTopOperatingSystems(Period, max)` | **Bar / Table** | Operating Systems | Operating systems with `screenPageViews`. Device OS breakdown. |
| `get(Period, metrics, dimensions, ...)` | **Custom (Builder)** | Custom Report | Generic GA4 query for building custom widgets (any metrics/dimensions, filters, order, limits). |


## GA4 Widgets (Not covered by spatie methods)

| UI Title | Display Type | Metrics | Dimensions | Filters | Notes |
|---|---|---|---|---|---|
| Realtime Users | **Realtime cards / table** | `activeUsers` | `pagePath`, `eventName` | realtime scope | Live users, pages and events right now (GA4 realtime via `get()` realtime). |
| Landing Pages | **Table (Ranked)** | `sessions`, `activeUsers`, `engagementRate` | `landingPage` | — | Entry pages where sessions start. GA → Reports → Landing pages. |
| Exit Pages | **Table (Ranked)** | `sessions` | `exitPage` | — | Pages where users leave the site. |
| Site Search | **Table (Ranked)** | `eventCount` | `searchTerm` | `eventName = search` | What users search on the site. |
| Zero‑result Searches | **Table (Ranked)** | `eventCount` | `searchTerm` | `eventName = search` AND `searchResults = 0` | Queries that returned no results. |
| Page Engagement | **Table (Ranked)** | `averageSessionDuration`, `engagementRate` | `pagePath` | — | How engaging each page is. |
| Conversion Paths | **Table (Ranked)** | `eventCount` | `pagePath` | `isKeyEvent = true` | Pages that lead to conversions. |
| Time of Day | **Bar / Line** | `activeUsers` | `hour` | — | When users are most active during the day. |
| Cities | **Bar / Table** | `screenPageViews` | `city` | — | Traffic by city (more granular than countries). |
| Content Growth / Decline | **Table (Δ comparison)** | `screenPageViews` | `pagePath` | compare two periods | Compare current vs previous period to show biggest winners & losers. |