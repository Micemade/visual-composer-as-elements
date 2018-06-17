var gulp = require("gulp"),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    fsCache = require('gulp-fs-cache'),
    rename = require("gulp-rename"),
    browserSync = require('browser-sync'),
    wpPot = require('gulp-wp-pot'),
    runSequence = require('run-sequence'),
    dos2unix = require('gulp-dos2unix-js');

// Get project name from json file
var jsonData = require('./package.json');

// Projekct variables
var $textdomain = jsonData.name,
    $plugin_name = jsonData.description,
    $project_version = jsonData.version,
    $packDest = 'C:/PROJEKTI/MICEMADE-PLUGIN-'+ $textdomain + '/',
    $packTemp = $packDest + $plugin_name;


// Configure browsersync
gulp.task('browser-sync', function() {
    var files = [
        //'./assets/css/vc_ase_styles.css',
        './assets/css/scss/_vc-elements.scss',
        './**/*.php'
    ];
    // Initialize BrowserSync with a PHP server
    browserSync.init(files, {
        proxy: 'http://localhost/larix/'
    });

});

gulp.task('styles', function () {
    
    // Process main css file(s) - style.scss and other scss files
    gulp.src('assets/css/scss/*.scss')
        .pipe(sass({
            'outputStyle' : 'compressed'
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('./assets/css'))
        .pipe(browserSync.stream()) //Possible use in future uncomment if neccessary

        // Process and output foundation.scss
        gulp.src('assets/css/scss/foundation6/*.scss')
        .pipe(sass({
            'outputStyle' : 'compressed'
        }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(rename({
            suffix: '.min'
            }))
        .pipe(gulp.dest('assets/css/'))
        .pipe(browserSync.stream());

});

// Process JS files (concatenate and uglify)
gulp.task('scripts', function() {
    var jsFsCache = fsCache('.tmp/jscache'); // save cache to .tmp/jscache
    return gulp.src('assets/js/vc_ase_scripts/**/*.js')
      .pipe(concat('vc_ase_scripts.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(jsFsCache)
        .pipe(uglify())
        .pipe(jsFsCache.restore)
        .pipe(gulp.dest('./assets/js'))

        .pipe(browserSync.stream());
})

// Generate translation .pot file from all php files
gulp.task('makepot', function () {
    return gulp.src('**/*.php')
        .pipe(wpPot( {
            domain: $textdomain,
            package: $textdomain,
            team: 'Micemade <alen@micemade.com>'
        } ))
        .pipe(gulp.dest('./languages/'+ $textdomain +'.pot'));
});
// dos2unix
gulp.task('eol', function () {
    return gulp.src(
    [
        //$packTemp + '/**/*.{css,js,php}',
        $packTemp + '/**/**',
    ])
    .pipe(dos2unix()) // This defaults to {feedback: false, write: false}
    .pipe(gulp.dest($packTemp))
  });
// end dos2unix

// Copy all files to destination
gulp.task('copy', function() {
    return gulp.src([
        './**',
        '!./node_modules', 
        '!./node_modules/**',
        '!./gulpfile.js',
        '!./package.json',
        '!./package-lock.json',
        '!./js/tmp', 
        '!./js/tmp/**',
        '!./**/*.db' // remove Windows Thumbs.db files
    ])
        .pipe(gulp.dest( $packTemp ));
})
// Zip the [$project_name] folder in pack desitnation
gulp.task('zipit', function() {
    return gulp.src( $packTemp + '**/**' )
    .pipe(zip( $project_name + '.' + $project_version +'.zip'))
    .pipe( gulp.dest( $packDest ) )
});
// Delete tempoarary folder ( copied theme folder in $packDest directory )
gulp.task('clean-temp', function () {
    del(
        $packTemp,
        {force: true }
    );
});

// #######################################
// The DEFAULT task will process sass, run browser-sync and start watchin for changes
gulp.task('default',['styles','browser-sync'], function() {
    gulp.watch([
        'sass/**/*.scss',
    ],['styles']);
});
// #######################################

// PACK EVERYTHING FOR INSTALLATION READY WP THEME ZIP
gulp.task('pack', function(){
    return runSequence(
        'makepot',
        'styles',
        'scripts',
        'copy',
        'eol'//,
        //'zipit',
        //'clean-temp'
    );
});

// Additional useful tasks
// RUN CSS AND JS FILES
gulp.task('cssjs', function(){
    return runSequence(
        'styles',
        'scripts'
    );
});
