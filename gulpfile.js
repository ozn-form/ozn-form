'use strict';

var gulp = require('gulp');
var sass = require("gulp-sass");
var debug = require('gulp-debug');
var concat = require('gulp-concat');
var minify = require('gulp-minify-css');
var rename = require('gulp-rename');
var sourcemaps = require('gulp-sourcemaps');
var watch = require('gulp-watch');
var runSequence = require('run-sequence');
var plumber = require('gulp-plumber');

// var browserify = require('browserify');
// var source = require('vinyl-source-stream');

gulp.task('default', function() {
	runSequence('watch');
});

gulp.task('watch', function () {
//   gulp.watch(['./assets/ozn-form/sass/*.sass'], ['build_sass_dev'])
   gulp.watch(['./assets/ozn-form/scss/*.scss'], ['build_sass_dev'])
});


gulp.task('build_sass_dev', function () {

    var files = [
//        './assets/ozn-form/sass/ozn-form.sass',
//        './assets/ozn-form/sass/base.sass'
        './assets/ozn-form/scss/ozn-form.scss'
    ];

    return gulp.src(files)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(concat('ozn-form.css'))
//        .pipe(minify())
        .pipe(rename({extname: '.min.css'}))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./release/css/'));
});

gulp.task('build_sass_release', function () {

    var files = [
//        './assets/ozn-form/sass/ozn-form.sass',
//        './assets/ozn-form/sass/base.sass'
        './assets/ozn-form/scss/ozn-form.scss'
    ];

    return gulp.src(files)
        .pipe(sass())
        .pipe(concat('ozn-form.css'))
        .pipe(minify())
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest('./release/css/'))
});

gulp.task('copy', function() {
  return gulp.src([
    './assets/ozn-form/scss/font/*'
  ])
  .pipe(gulp.dest('./release/css/font'));
});