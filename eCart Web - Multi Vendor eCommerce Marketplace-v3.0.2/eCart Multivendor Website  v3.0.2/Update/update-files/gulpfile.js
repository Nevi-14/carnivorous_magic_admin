const gulp = require('gulp');
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const autoprefixer = require('autoprefixer');
const { src, dest,  parallel } = require('gulp');

const jspathheader = [
  'public/themes/eCart/js/jquery-3.5.1.min.js',
  'public/themes/eCart/js/bootstrap.bundle.min.js',
  'public/themes/eCart/js/jquery-ui.min.js',
  'public/themes/eCart/js/intlTelInput.js',
  'public/themes/eCart/js/alertify.min.js',
  'public/themes/eCart/js/sweetalert.min.js',
];

const jspathfooter = [
  'public/themes/eCart/js/plugins.js',
  'public/themes/eCart/js/sweetalert.min.js',
  'public/themes/eCart/js/semantic.min.js',
  'public/themes/eCart/js/elevatezoom.js',
  'public/themes/eCart/js/owl-carousel.js',
  'public/themes/eCart/js/wow.js',
  'public/themes/eCart/js/script.js',
  'public/themes/eCart/js/cartajax.js',
  'public/themes/eCart/js/lazy.js',
  'public/themes/eCart/js/spectrum.min.js',
]

//rtl
const rtljspathfooter = [
  'public/themes/eCart/js/plugins.js',
  'public/themes/eCart/js/sweetalert.min.js',
  'public/themes/eCart/js/semantic.min.js',
  'public/themes/eCart/js/elevatezoom.js',
  'public/themes/eCart/js/owl-carousel.js',
  'public/themes/eCart/js/wow.js',
  'public/themes/eCart/js/rtlscript.js',
  'public/themes/eCart/js/cartajax.js',
  'public/themes/eCart/js/lazy.js',
  'public/themes/eCart/js/spectrum.min.js',
]

const cssPath = [
  'public/themes/eCart/css/select2.min.css',
  'public/themes/eCart/css/semantic.min.css',
  'public/themes/eCart/css/bootstrap.min.css',
  'public/themes/eCart/css/jquery-ui.min.css',
  'public/themes/eCart/css/plugin.css',
  'public/themes/eCart/css/owl-carousel.css',
  'public/themes/eCart/css/calender.css',
  'public/themes/eCart/css/intlTelInput.css',
  'public/themes/eCart/css/animate.css',
  'public/themes/eCart/css/custom.css',
  'public/themes/eCart/css/sweetalert.min.css',
  'public/themes/eCart/css/alertify.min.css',
  'public/themes/eCart/css/spectrum.min.css',
];

//rtl
const rtlcssPath = [
  'public/themes/eCart/css/select2.min.css',
  'public/themes/eCart/css/semantic.min.css',
  'public/themes/eCart/css/bootstrap.rtl.min.css',
  'public/themes/eCart/css/jquery-ui.min.css',
  'public/themes/eCart/css/plugin.css',
  'public/themes/eCart/css/owl-carousel.css',
  'public/themes/eCart/css/calender.css',
  'public/themes/eCart/css/rtlintlTelInput.css',
  'public/themes/eCart/css/animate.css',
  'public/themes/eCart/css/rtlcustom.css',
  'public/themes/eCart/css/sweetalert.min.css',
  'public/themes/eCart/css/alertify.min.css',
  'public/themes/eCart/css/spectrum.min.css',
];



function jsTask() {
  return src(jspathheader)
    .pipe(sourcemaps.init())
    .pipe(concat('headerbundle.js'))
    .pipe(terser())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/themes/eCart/js'));
}

function jsTask2() {
  return src(jspathfooter)
    .pipe(sourcemaps.init())
    .pipe(concat('footerbundle.js'))
    .pipe(terser())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/themes/eCart/js'));
}

//rtl
function rtljsTask2() {
  return src(rtljspathfooter)
    .pipe(sourcemaps.init())
    .pipe(concat('rtlfooterbundle.js'))
    .pipe(terser())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/themes/eCart/js'));
}

function cssTask() {
  return src(cssPath)
    .pipe(sourcemaps.init())
    .pipe(concat('bundle.css'))
    .pipe(postcss([autoprefixer(), cssnano()])) //not all plugins work with postcss only the ones mentioned in their documentation
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/themes/eCart/css'));
}

//rtl
function rtlcssTask() {
  return src(rtlcssPath)
    .pipe(sourcemaps.init())
    .pipe(concat('rtlbundle.css'))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/themes/eCart/css'));
}


exports.cssTask = cssTask;
exports.jsTask = jsTask;
exports.jsTask2 = jsTask2;
exports.rtlcssTask = rtlcssTask;
exports.rtljsTask2 = rtljsTask2;
exports.default = parallel(cssTask, jsTask,jsTask2, rtlcssTask, rtljsTask2)