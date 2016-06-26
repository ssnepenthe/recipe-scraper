var gulp = require('gulp');
var phpunit = require('gulp-phpunit');

gulp.task('phpunit', function() {
  gulp.src('phpunit.xml')
    .pipe(phpunit());
});

gulp.task('watch', function() {
  gulp.watch(['src/**/*.php', 'tests/**/*.php'], ['phpunit']);
});

gulp.task('default', ['watch']);
