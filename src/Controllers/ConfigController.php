<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics\Controllers;

use Illuminate\Http\Request;
use Isapp\GoogleAnalytics\Concerns\HasConfig;
use Statamic\Facades\Blueprint;
use Statamic\Facades\File;
use Statamic\Facades\User;
use Statamic\Facades\YAML;
use Statamic\Http\Controllers\CP\CpController;

use function collect;
use function config;
use function response;
use function view;

class ConfigController extends CpController
{
    use HasConfig;

    public function index()
    {
        if (User::current()->cannot('manage preferences')) {
            return redirect()->route('statamic.cp.preferences.user.edit');
        }
        $blueprint = $this->blueprint();

        $fields = $blueprint
            ->fields()
            ->addValues($this->values())
            ->preProcess();

        return view('isapp-analytics::settings', [
            'blueprint' => $blueprint->toPublishArray(),
            'values' => $fields->values(),
            'meta' => $fields->meta(),
        ]);
    }

    public function multiEnabled(): bool
    {
        return (bool) config('statamic.system.multisite', false);
    }

    public function update(Request $request)
    {
        $blueprint = $this->blueprint();

        $fields = $blueprint
            ->fields()
            ->addValues($request->all());

        $fields->validate();

        $values = $fields
            ->process()
            ->values()
            ->all();

        // Normalize form values to sites config, since we always want array of sites keyed by handle, etc.
        $sites = collect($this->multiEnabled() ? $values['sites'] : [$values])
            ->keyBy('handle')
            ->transform(function ($site) {
                return collect($site)
                    ->except(['id', 'handle'])
                    ->filter()
                    ->all();
            })
            ->all();

        $this->save($this->setSites($sites));

        return response('', 204);
    }

    public function save($sites)
    {
        // Save sites to store
        File::put($this->path(), YAML::dump($this->config($sites)));
    }

    public function config($sites): array
    {
        return $sites
            ->keyBy
            ->handle()
            ->map
            ->rawConfig()
            ->all();
    }

    protected function blueprint()
    {
        $siteFields = YAML::file(__DIR__ . '/../../resources/settings.yaml')->parse();

        //        \array_walk_recursive($siteFields, function (&$value, $key){
        //            if($key === 'display')
        //        });

        return Blueprint::make()->setContents($siteFields);
    }
}
