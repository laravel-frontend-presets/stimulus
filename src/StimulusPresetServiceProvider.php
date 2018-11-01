<?php

namespace LaravelFrontendPresets\StimulusPreset;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class StimulusPresetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('stimulus', function ($command) {
            StimulusPreset::install($this->getOptions($command));
            $command->info('Stimulus scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }

    protected function getOptions($command)
    {
        $options = $command->option('option');

        return [
            StimulusPreset::OPTION_TURBOLINKS => in_array(StimulusPreset::OPTION_TURBOLINKS, $options),
        ];
    }
}
