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

gulp.task('default', function() {
	runSequence('watch');
});

gulp.task('watch', function () {
   gulp.watch(['./assets/sass/*.sass'])
});

gulp.task('sass', function () {

    var files = [
        './src/assets/sass/ozn-form.sass'
    ];

    return gulp.src(files)
        .pipe(sass())
        .pipe(concat('ozn-form.css'))
        .pipe(minify())
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest('./release/ozn-form/css/'));
});

gulp.task('copy', function() {
  return gulp.src([
    './assets/ozn-form/sass/font/*'
  ])
  .pipe(gulp.dest('./release/ozn-form/css/font'));
});

