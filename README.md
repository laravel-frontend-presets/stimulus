# Laravel 5.5+ frontend preset for Stimulus

This package makes it easy to use [Stimulus](https://stimulusjs.org/), a modest JavaScript framework for the HTML you already have, with Laravel 5.5+.

Read more on [the origin of Stimulus](https://stimulusjs.org/handbook/origin).

## Contents

- [Installation/Usage](#installation-usage)
- [Options](#options)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation/Usage

To install this preset on your laravel application, simply run:

```bash
composer require laravel-frontend-presets/stimulus
php artisan preset stimulus
npm install # or yarn install
npm run dev # or yarn dev
```

This will:

- Add the Stimulus preset package
- Remove JavaScript files other than `bootstrap.js`
- Add JavaScript files for leveraging Stimulus
- Install Node.js dependencies
- Build frontend assets

Once complete, ensure that the built `js/app.js` file in your `public` directory is loaded in a Blade layout or view, e.g.:

```html
<script type="text/javascript" defer src="{{ mix('/js/app.js') }}"></script>
```

The Stimulus controllers defined in `resources/assets/js/controllers` (or `resources/js/controllers` for Laravel 5.7+) will be available at runtime.

> **Note:** After updating your defined Stimulus controllers, remember to rebuild your frontend assets to reflect your changes.

Your Stimulus controllers will be included in your project automatically via Webpack's `require.context` feature and a Stimulus helper. If you're not using Laravel Mix or other Webpack-based build tools, review the Stimulus Handbook for [alternative integration steps](https://stimulusjs.org/handbook/installing).

Stimulus operates based on HTML data attributes, so update your view(s) to make use of your defined Stimulus controllers. For the default `hello-controller`, the necessary HTML would look similar to:

```html
<div data-controller="hello">
    <input data-target="hello.name" type="text">
    <button data-action="click->hello#greet">Greet</button>
</div>
```

Learn more about Stimulus by reading the [handbook](https://stimulusjs.org/handbook/introduction) and/or [reference](https://stimulusjs.org/reference/controllers).

## Options

- `with-turbolinks` - Adds [Turbolinks](https://github.com/turbolinks/turbolinks) to make navigating your web application faster.

  Example:

  ```bash
  php artisan preset stimulus --option=with-turbolinks
  ```

## Contributing

Please check our contributing rules in [our website](https://laravel-frontend-presets.github.io) for details.

## Credits

- [Shane Logsdon](https://github.com/slogsdon)
- [All Contributors](../../contributors)

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
