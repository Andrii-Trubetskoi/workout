'use strict'

const gulp = require('gulp')

gulp.task('default', ['styles', 'scripts'])

gulp.task('styles', () => {

  const sass = require('gulp-sass')

  let sassFiles = './assets/styles/**/*.scss'
  let cssDest = './web/styles/'

  gulp.src(sassFiles)
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest(cssDest))
})

gulp.task('scripts', function () {

  const browserify = require('browserify')
  const babelify = require('babelify')
  const source = require('vinyl-source-stream')
  const buffer = require('vinyl-buffer')
  const sourcemaps = require('gulp-sourcemaps')

  return browserify({entries: './assets/js/index.js', debug: true})
    .transform(babelify, {presets: ['es2015']})
    .bundle()
    .pipe(source('index.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write('./maps'))
    .pipe(gulp.dest('./web/js'))
})