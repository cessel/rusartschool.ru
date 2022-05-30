var gulp        = require("gulp"),
    sass        = require("gulp-sass"),
    compass     = require('gulp-compass'),
    livereload  = require('gulp-livereload'),
    concat      = require('gulp-concat'),
    uglify      = require('gulp-uglifyjs'),
    cssnano     = require('gulp-cssnano'),
    rename      = require('gulp-rename'),
    imgmin      = require('gulp-imagemin'),
    pngq        = require('imagemin-pngquant'),
    autopref    = require('gulp-autoprefixer'),
    plumber    = require('gulp-plumber'),
    cache        = require('gulp-cache');


gulp.task("sass",function(done)
    {
        return gulp.src('sass/**/*.+(sass|scss)')
        /*.pipe(compass({
            config_file: __dirname + '/config/compass.rb',
            sass: 'sass',
            css:'css'
        })).on('error', function(error) {
            // у нас ошибка
            done("ОШИБКА1" + error);
        })*/
            .pipe(sass({outputStyle: 'compact', precision: 10})
                .on('error', sass.logError)
            )
            .pipe(autopref(['last 15 versions','> 1%', 'ie 8', 'ie 7'],{'cascade':true})).on('error', function(error) {
                // у нас ошибка
                done("ОШИБКА2" + error);
            })
            .pipe(gulp.dest('css'));
    });

gulp.task('css-libs:nano',['sass'],function()
{
    return gulp.src(
        [
        'css/*.css'
        ])
        .pipe(concat('styles.min.css'))
        .pipe(cssnano())
        .pipe(rename({suffix:'.min'}))
        .pipe(gulp.dest('css'));
});

gulp.task('img',function()
    {
       return gulp.src
        (
            'img/**/*.*'
        )
           .pipe(cache(imgmin(
               {
                   interlaces:true
                   ,progressive:true
                   ,svgoPlugins:[{removeViewBox:false}]
                   ,use:[pngq()]
               }
           )))
           .pipe(gulp.dest('img'));
    });

gulp.task('default',['sass'],function()
    {
        gulp.watch('sass/**/*.+(sass|scss)',['sass']);
    });
