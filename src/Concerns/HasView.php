<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics\Concerns;

use Str;

use function config;

trait HasView
{
    use HasConfig;

    /**
     * The HTML that should be shown in the widget.
     */
    public function html(string $view = 'widget'): string|\Illuminate\View\View
    {
        $values = $this->values();
        $propertyId = $values['property_id'];
        if (empty($propertyId)) {
            $propertyId = config('analytics.property_id');
            if (empty($propertyId)) {
                return '';
            }
        }

        $charts = collect($values)->filter(fn ($item) => \is_bool($item) && $item)
            ->keys()
            ->map(fn ($item) => Str::ucfirst(Str::camel($item)));

        return view('isapp-analytics::' . $view, [
            'property_id' => $values['property_id'] ?? '',
            'charts' => $charts,
        ]);
    }
}
