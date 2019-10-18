let ftp = require("vinyl-ftp"),
gutil = require("gulp-util");
let conn = ftp.create({
	host: "92.53.96.22",
	user: "ce21516_kramola",
	password: "mA1cjcWNmA1cjcWN",
	parallel: 10,
	log: gutil.log
});
let conn1 = ftp.create({
	host: "webproks.beget.tech",
	user: "webproks",
	password: "ii06081997ii",
	parallel: 10,
	log: gutil.log
});
module.exports = function () {

    $.gulp.task('deploy', () => {
        return $.gulp.src(['./build/**','!./build/smartbasket/**','!./build/.htaccess','!./build/robots.txt','!./build/grep.php','!./build/metrika.html','!./build/sitemap.xml','!./build/favicon.ico'], { buffer: false })
				.pipe(conn.dest("/public_html/"));
    });
    $.gulp.task('deploy:beget', () => {
        return $.gulp.src(['./build/**','!./build/smartbasket/**','!./build/.htaccess','!./build/robots.txt','!./build/grep.php','!./build/metrika.html','!./build/sitemap.xml','!./build/favicon.ico'], { buffer: false })
				.pipe(conn1.dest("/webprogrammer77.ru/public_html/kramola/"));
    });
};





