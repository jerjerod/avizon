var gulp = require('gulp');
var elixir = require('laravel-elixir');

/**
 * Copy any needed files.
 *
 * Do a 'gulp copyfiles' after bower updates
 */
gulp.task("copyfiles", function() {
  /*jquery*/
  gulp.src("vendor/bower_components/jquery/dist/jquery.min.js")
    .pipe(gulp.dest("resources/assets/js/"));

  /*bootstrap*/
  gulp.src("vendor/bower_components/bootstrap/less/**")
    .pipe(gulp.dest("resources/assets/less/bootstrap"));
  gulp.src("vendor/bower_components/bootstrap/dist/js/bootstrap.min.js")
    .pipe(gulp.dest("resources/assets/js/"));
  gulp.src("vendor/bower_components/bootstrap/dist/fonts/**")
    .pipe(gulp.dest("public/assets/fonts"));

  /*bootstrap-chosen-less-js*/
  gulp.src("vendor/bower_components/bootstrap-chosen-less-js/**")
    .pipe(gulp.dest("resources/assets/less/bootstrap-chosen-less-js"));
  gulp.src("vendor/bower_components/bootstrap-chosen-less-js/chosen.jquery.min.js")
    .pipe(gulp.dest("resources/assets/js/"));
  gulp.src("vendor/bower_components/bootstrap-chosen-less-js/chosen-sprite.png")
    .pipe(gulp.dest("public/assets/css"));
  gulp.src("vendor/bower_components/bootstrap-chosen-less-js/chosen-sprite@2x.png")
    .pipe(gulp.dest("public/assets/css"));

  /*font-awesome*/
  gulp.src("vendor/bower_components/fontawesome/less/**")
      .pipe(gulp.dest("resources/assets/less/fontawesome"));
  gulp.src("vendor/bower_components/fontawesome/fonts/**")
      .pipe(gulp.dest("public/assets/fonts"));

  /*framework sb-admin*/
  gulp.src("vendor/bower_components/startbootstrap-sb-admin-2/less/**")
      .pipe(gulp.dest("resources/assets/less/admin"));

  /*menu accordeon*/
  gulp.src("vendor/bower_components/metisMenu/dist/metisMenu.js")
    .pipe(gulp.dest("resources/assets/js/"));
  gulp.src("vendor/bower_components/metisMenu/dist/metisMenu.css")
    .pipe(gulp.dest("resources/assets/css/"));

  /*datatables*/
  gulp.src("vendor/bower_components/datatables/media/js/jquery.dataTables.min.js")
    .pipe(gulp.dest("resources/assets/js/"));
  gulp.src("vendor/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js")
    .pipe(gulp.dest("resources/assets/js/"));
  gulp.src("vendor/bower_components/datatables/media/css/dataTables.bootstrap.css")
    .pipe(gulp.dest("resources/assets/css/"));

  /*Mapbox*/
  gulp.src("vendor/bower_components/mapbox.js/mapbox.js")
    .pipe(gulp.dest("resources/assets/js/"));
  gulp.src("vendor/bower_components/mapbox.js/mapbox.css")
    .pipe(gulp.dest("resources/assets/css/"));

  /*D3.js*/
  gulp.src("vendor/bower_components/d3/d3.min.js")
    .pipe(gulp.dest("resources/assets/js/"));
  gulp.src("vendor/bower_components/nvd3/build/nv.d3.min.js")
    .pipe(gulp.dest("resources/assets/js/"));
  gulp.src("vendor/bower_components/nvd3/build/nv.d3.min.css")
    .pipe(gulp.dest("resources/assets/css/"));

});

/**
 * Default gulp is to run this elixir stuff
 */
elixir(function(mix) {

  // Combine scripts
  mix.scripts([
      'js/jquery.min.js',
      'js/bootstrap.min.js',
      'js/chosen.jquery.min.js'
    ],
    'public/assets/js/app.js',
    'resources/assets'
  );
  mix.scripts([
      'js/metisMenu.js',
      'js/jquery.dataTables.min.js',
      'js/dataTables.bootstrap.min.js',
      'js/custom.js'
    ],
    'public/assets/js/menu.js',
    'resources/assets'
  );
  mix.scripts([
      'css/metisMenu.css',
      'css/dataTables.bootstrap.css'
    ],
    'public/assets/css/menu.css',
    'resources/assets'
  );
  mix.scripts([
      'js/mapbox.js',
      'js/google.js'
    ],
    'public/assets/js/mapbox.js',
    'resources/assets'
  );
  mix.scripts([
      'css/mapbox.css',
      'css/custom_map.css'
    ],
    'public/assets/css/map.css',
    'resources/assets'
  );
  mix.scripts([
      'js/d3.min.js',
      'js/nv.d3.min.js'
    ],
    'public/assets/js/d3.js',
    'resources/assets'
  );
  mix.scripts([
      'css/nv.d3.min.css'
    ],
    'public/assets/css/d3.css',
    'resources/assets'
  );



  // Compile Less
  mix.less('style.less', 'public/assets/css/app.css');
  mix.less('admin.less', 'public/assets/css/admin.css');
});