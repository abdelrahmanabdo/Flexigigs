var gulp = require("gulp"),
	plumber = require("gulp-plumber"),
	rename = require("gulp-rename");
var autoprefixer = require("gulp-autoprefixer");
var minifycss = require("gulp-uglifycss");
var sourcemaps = require("gulp-sourcemaps");
var sass = require("gulp-sass");
var browserSync = require("browser-sync");
var notify = require("gulp-notify");

gulp.task("browser-sync", function() {
	browserSync.init({
		// For more options
		// @link http://www.browsersync.io/docs/options/

		// Project URL.
		proxy: "http://localhost/flexigigs-laravel/public",

		// `true` Automatically open the browser with BrowserSync live server.
		// `false` Stop the browser from automatically opening.
		open: false,

		// Inject CSS changes.
		// Commnet it to reload browser for every CSS change.
		injectChanges: true,

		// Use a specific port (instead of the one auto-detected by Browsersync).
		port: 8080
	});
});

gulp.task("bs-reload", function() {
	browserSync.reload();
});

gulp.task("styles", function() {
	gulp
		.src(["sass/**/*.scss"])
		.pipe(sourcemaps.init())
		.pipe(
			plumber({
				errorHandler: function(error) {
					console.log(error.message);
					this.emit("end");
				}
			})
		)
		.pipe(sass())
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer("last 2 versions"))
		.pipe(sourcemaps.write("css/"))
		.pipe(gulp.dest("css/"))
		.pipe(rename({ suffix: ".min" }))
		.pipe(
			minifycss({
				maxLineLen: 10
			})
		)
		.pipe(gulp.dest("css/"))
		.pipe(browserSync.reload({ stream: true }))
		.pipe(
			notify({ message: 'TASK: "styles" Completed! 💯', onLast: true })
		);
});

gulp.task("default", ["browser-sync"], function() {
	gulp.watch("sass/**/*.scss", ["styles"]);
	gulp.watch("*.html", ["bs-reload"]);
});
