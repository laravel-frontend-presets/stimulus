<?php

namespace LaravelFrontendPresets\StimulusPreset;

use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;

class StimulusPreset extends Preset
{
    const OPTION_TURBOLINKS = 'with-turbolinks';

    /**
     * Preset options.
     *
     * @var array
     */
    protected static $options = [];

    /**
     * Resolved application asset path.
     *
     * @var string
     */
    protected static $resourceAssetPath = null;

    /**
     * Resolved application public path.
     *
     * @var string
     */
    protected static $resourcePublicPath = null;

    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install($options)
    {
        static::$options = $options;

        static::resolveAssetPaths();
        static::updatePackages();
        static::ensureControllersDirectoryExists();
        static::updateJsFiles();
        static::removeNodeModules();
    }

    /**
     * Resolve the resource asset path.
     *
     * Handles differences in asset location, e.g. `resources/js` vs
     * `resources/assets/js`.
     *
     * @return void
     */
    protected static function resolveAssetPaths()
    {
        $filesystem = new Filesystem;

        if ($filesystem->isDirectory($directory = resource_path('assets'))) {
            static::$resourceAssetPath = $directory;
            static::$resourcePublicPath = public_path('assets');
            return;
        }

        static::$resourceAssetPath = resource_path();
        static::$resourcePublicPath = public_path();
    }

    /**
     * Ensure the controllers directory we need exists.
     *
     * @return void
     */
    protected static function ensureControllersDirectoryExists()
    {
        $filesystem = new Filesystem;

        if (!$filesystem->isDirectory($directory = static::assetPath('js/controllers'))) {
            $filesystem->makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Update the given package array.
     *
     * @param array $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        $toAdd = ['stimulus' => '^1.0'];

        if (static::hasOption(static::OPTION_TURBOLINKS)) {
            $toAdd['turbolinks'] = '^5.0';
        }

        return $toAdd + Arr::except($packages, [
            // react preset
            'babel-preset-react',
            'react',
            'react-dom',
            // vue preset
            'vue',
        ]);
    }

    /**
     * Update the JS files.
     *
     * @return void
     */
    protected static function updateJsFiles()
    {
        // remove exisiting js files
        tap(new Filesystem, function ($files) {
            $files->delete(static::assetPath('js/app.js'));
            $files->deleteDirectory(static::assetPath('js/components'));
            $files->delete(static::publicPath('js/app.js'));
        });

        // copy a new files from the stubs folder
        $app = sprintf(
            'js/app%s.js',
            static::hasOption(static::OPTION_TURBOLINKS)
                ? '-' . static::OPTION_TURBOLINKS
                : ''
        );

        copy(static::stubPath($app), static::assetPath('js/app.js'));
        copy(
            static::stubPath('js/controllers/hello-controller.js'),
            static::assetPath('js/controllers/hello-controller.js')
        );
    }

    // helpers

    /**
     * Gets the application's asset path.
     *
     * @param string $path
     * @return string
     */
    protected static function assetPath($path)
    {
        return sprintf('%s/%s', static::$resourceAssetPath, $path);
    }

    /**
     * Checks if an option has been set on the command line.
     *
     * @param string $name
     * @return boolean
     */
    protected static function hasOption($name)
    {
        return isset(static::$options[$name]) && static::$options[$name] === true;
    }

    /**
     * Gets the package's stub path.
     *
     * @param string $path
     * @return string
     */
    protected static function stubPath($path)
    {
        return sprintf('%s/stimulus-stubs/%s', __DIR__, $path);
    }

    /**
     * Gets the application's public path.
     *
     * @param string $path
     * @return string
     */
    protected static function publicPath($path)
    {
        return sprintf('%s/%s', static::$resourcePublicPath, $path);
    }
}
