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
var extender = require('gulp-html-extend');
var browserSync = require('browser-sync').create();


// var browserify = require('browserify');
// var source = require('vinyl-source-stream');

gulp.task('default', function() {
	runSequence('watch');
});

gulp.task('watch', function () {
//   gulp.watch(['./assets/ozn-form/sass/*.sass'], ['build_sass_dev'])
   gulp.watch(['./assets/ozn-form/scss/*.scss'], ['build_sass_dev'],['build_sass_core'])
});


gulp.task('build_sass_dev', function () {

    var files = [
        './assets/eachsite/sass/eachsite.sass'
    ];

    return gulp.src(files)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(concat('eachsite.css'))
        .pipe(rename('style.min.css'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./order-form/css/'));
});

gulp.task('build_sass_release', function () {

    var files = [
        './assets/eachsite/sass/eachsite.sass'
    ];

    return gulp.src(files)
        .pipe(sass())
        .pipe(minify())
        .pipe(concat('eachsite.css'))
        .pipe(rename('style.min.css'))
        .pipe(gulp.dest('./order-form/css/'));
});

gulp.task('build_sass_core', function () {

    var files = [
        './assets/ozn-form/sass/ozn-form.sass'
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
    './assets/ozn-form/sass/font/*'
  ])
  .pipe(gulp.dest('./release/css/font'));
});


gulp.task('output_document', function () {
    gulp.src('./html-extend-src/document/pages/**/*')
        .pipe(extender({annotations:false,verbose:false})) // default options
        .pipe(gulp.dest('./document'))
});

gulp.task('output_document_style', function () {

    var files = [
        './assets/document/sass/**/*.sass'
    ];

    return gulp.src(files)
        .pipe(sass())
        .pipe(minify())
        .pipe(concat('dmain.css'))
        .pipe(rename('style.min.css'))
        .pipe(gulp.dest('./document/css/'));
});

gulp.task('document_watch', ['browser-sync']);

gulp.task('browser-sync', function() {
    browserSync.init();
});

gulp.task('bs-reload', function () {
    browserSync.reload();
});

gulp.task('document_watch', ['browser-sync'], function () {
   gulp.watch(['./html-extend-src/document/layout/**/*'], ['output_document']);
   gulp.watch(['./html-extend-src/document/pages/**/*'], ['output_document']);
   gulp.watch(['./assets/document/sass/**/*.sass'], ['output_document_style']);
   gulp.watch("document/*.html", ['bs-reload']);
   gulp.watch("document/css/*.css", ['bs-reload']);
});
