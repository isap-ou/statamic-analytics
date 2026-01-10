<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics\Concerns;

use Str;

use function collect;
use function config;

trait HasView
{
    use HasConfig;

    /**
     * The HTML that should be shown in the widget.
     */
    public function html(string $view = 'widget'): string|\Illuminate\View\View
    {
        $filterWidgetsKey = $view === 'widget' ? 'is_widget_enabled' : 'is_page_enabled';
        $values = $this->values();

        $widgets = collect($values['widgets'] ?? [])->filter(fn ($item) => ! empty($item[$filterWidgetsKey]));

        if ($widgets->isEmpty()) {
            return '';
        }

        $propertyId = $values['property_id'];
        if (empty($propertyId)) {
            $propertyId = config('analytics.property_id');
            if (empty($propertyId)) {
                return '';
            }
        }

        $charts = $widgets->pluck('widget')
            ->map(fn ($item) => Str::ucfirst(Str::camel($item)));

        return view('isapp-analytics::' . $view, [
            'property_id' => $values['property_id'] ?? '',
            'charts' => $charts,
        ]);
    }
}
