
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Stimulus and other libraries. It is a great starting point when
 * building robust, powerful web applications using Stimulus and Laravel.
 */

import './bootstrap';

import { Application } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';

/**
 * Next, we will create a fresh Stimulus application instance and autoload
 * available controllers. Then, you may begin adding controllers to this
 * application or customize the JavaScript scaffolding to fit your unique
 * needs.
 */

const application = Application.start();
const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));
