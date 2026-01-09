<?php

declare(strict_types = 1);

namespace Isapp\GoogleAnalytics\Widgets;

use Illuminate\Support\Str;
use Isapp\GoogleAnalytics\Concerns\HasGoogleAnalyticsConfig;
use Statamic\Widgets\Widget;

use function collect;

class GoogleAnalytics extends Widget
{
    use HasGoogleAnalyticsConfig;

    /**
     * The HTML that should be shown in the widget.
     */
    public function html(): string|\Illuminate\View\View
    {
        $values = $this->values();

        if (empty($values['property_id'])) {
            return '';
        }

        $charts = collect($values)->filter(fn ($item) => \is_bool($item) && $item)
            ->keys()
            ->map(fn ($item) => Str::ucfirst(Str::camel($item)));

        return view('google-analytics::widget', [
            'property_id' => $values['property_id'] ?? '',
            'charts' => $charts,
        ]);
    }
}
