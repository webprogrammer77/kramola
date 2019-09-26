module.exports = function () {
	$.gulp.task('copy', () => {
		return $.gulp.src([
					'dev/assets/**'
			])
			.pipe($.gulp.dest('build/'))
			.pipe($.browserSync.reload({
				stream: true
		}));
	});
};
