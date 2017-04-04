Gulp = {
	self    : null,
	uglify  : null,
	cssmin  : null,
	sass    : null,
	init: function(){
		Gulp.self   = require('gulp');
		Gulp.uglify = require('gulp-uglify');
		Gulp.cssmin = require('gulp-cssmin');
		Gulp.sass   = require('gulp-sass');
		Gulp.default();
		Gulp.js();
		Gulp.scss();
		Gulp.css();
		Gulp.watch();
		Gulp.wsass();
	},
	scss: function(){
		Gulp.self.task('scss', function(){
			console.log('[SASS] Compilando Arquivos do Sass');
			Gulp.self.src('./assets/scss/base/base.scss')
			.pipe(Gulp.sass())
			.pipe(Gulp.self.dest('./assets/css/src/base'));
			Gulp.self.src('./assets/scss/pages/**/*.scss')
			.pipe(Gulp.sass())
			.pipe(Gulp.self.dest('./assets/css/src/pages'));
		});
	},
	css: function(){
		Gulp.self.task('css', function(){
			console.log('[CSS] Minificando Arquivos CSS');
			Gulp.self.src('./assets/css/src/**/*.css')
			.pipe(Gulp.cssmin())
			.pipe(Gulp.self.dest('./assets/css/dist'));
		});
	},
	js: function(){
		Gulp.self.task('js', function(){
			console.log('[JS] Minificando Arquivos JavaScript');
			Gulp.self.src(['./js/src/**/*.js', '!js/dist/**'])
			.pipe(Gulp.uglify())
			.pipe(Gulp.self.dest('./js/dist'))
		});
	},
	default: function(){
		Gulp.self.task('default', ['scss', 'css', 'js']);
	},
	watch: function(){
		Gulp.self.task('watch', function(){
			Gulp.self.watch('./js/**/*.js', ['js']);
			Gulp.self.watch('./assets/css/src/**', ['css']);
			Gulp.self.watch('./assets/scss/**', ['scss']);
		});
	},
	wsass: function(){
		Gulp.self.task('wsass', function(){
			Gulp.self.watch('./assets/scss/**', ['scss']);
		});
	}
}
Gulp.init();