const gulp = require("gulp");
const sass = require("gulp-sass");
const autoPrefixer = require("gulp-autoprefixer");
const clean = require("gulp-clean-css");
const babel = require("gulp-babel");
const { parallel } = require("gulp");

const server = require("browser-sync").create();

const styles = function() {
    return gulp.src("resources/*.sass")
        .pipe(sass())
        .pipe(autoPrefixer())
        .pipe(clean())
        .pipe(gulp.dest("assets/styles"))
        .pipe(server.stream());
}

const scripts = function() {
    return gulp.src("resources/script.js")
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(gulp.dest("assets/scripts"))
        .pipe(server.stream());
}

const serve = function() {
    server.init({
        proxy: "http://velo.ro:8888",
        open: false
    });

    gulp.watch("resources/*.sass", styles);
    gulp.watch("resources/*.js", scripts);
    gulp.watch("**/**/*.php").on('change', server.reload);
}

exports.styles = styles;
exports.scripts = scripts;
exports.default = parallel(styles, scripts, serve);