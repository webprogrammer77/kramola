"use strict";

global.$ = {
  path: {
    task: require("./gulp/path/tasks.js")
  },
  gulp: require("gulp"),
  browserSync: require("browser-sync").create(),
  del: require("del")
};

$.path.task.forEach(function(taskPath) {
  require(taskPath)();
});

$.gulp.task(
  "dev",
  $.gulp.series(
    "clean",
    $.gulp.parallel(
      "pug",
      "fonts",
      "copy",
      "styles:dev",
      "img:dev",
      "libsJS:dev",
      "js:dev",
      "svg"
    )
  )
);

$.gulp.task(
  "build",
  $.gulp.series(
    "clean",
    $.gulp.parallel(
      "pug",
      "fonts",
      "copy",
      "styles:build-min",
      "img:build",
      "libsJS:build",
      "js:build-min",
      "svg"
    )
  )
);
$.gulp.task("default", $.gulp.series("dev", $.gulp.parallel("watch", "serve")));
$.gulp.task("deploy", $.gulp.series("build","deploy"));
$.gulp.task("deploy:beget", $.gulp.series("build","deploy:beget"));