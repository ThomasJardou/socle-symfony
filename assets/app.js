/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import 'line-awesome/dist/line-awesome/css/line-awesome.min.css';
import 'chart.js'
const $ = require('jquery');
global.$ = global.jQuery = $;

require('alpinejs')
require('chart.js')
import 'select2/dist/css/select2.min.css'
require('select2');
import './styles/app.css';

// start the Stimulus application
import './bootstrap';