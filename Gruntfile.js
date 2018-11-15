'use strict';
module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Watches for changes and runs tasks
    watch: {
      sass: { // watch sass files
        files: ['assets/sass/*.scss'],
        tasks: ['css_task']
      },
      css: { // livereload with min css update
        files: ['assets/css/**/*.min.css'],
        options: {
          livereload: true
        }
      },
      js: {
        files: ['assets/js/**/*.js', '!assets/js/**/*.min.js'],
        tasks: ['js_task'],
        options: {
          livereload: true
        }
      },
      svg: {
        files: ['assets/svg/**/*.svg'],
        tasks: ['svg_task']
      }
    },

    // Clean minified css and js
    clean: {
      css: {
        src: ['assets/css/*.css', 'assets/css/*.map']
      },
      js: {
        src: ['assets/js/scripts.min.js']
      },
    },

    // Compile sass files into CSS

    sass: {
      dist: {
        options: {
          sourcemap: 'none'
        },
        files: {
          'assets/css/global.css': 'assets/sass/style.scss'
        }
      }
    },

    // Apply post-processors to CSS - pixrem, autoprefixer, css-mqpacker and minify
    postcss: {
      options: {
        map: false, // inline sourcemaps
        processors: [
          require('sort-css-media-queries'),
          require('pixrem')(),
          require('autoprefixer')({
            browsers: [
              'Android 2.3',
              'Android >= 4',
              'Chrome >= 20',
              'Firefox >= 24',
              'Explorer >= 8',
              'iOS >= 6',
              'Opera >= 12',
              'Safari >= 6'
            ]
          }), // add vendor prefixes
          require('css-mqpacker')({
            sort: require('sort-css-media-queries').desktopFirst
          }), // Pack media queries
          require('cssnano')({
            preset: 'default'
          }) // minify the result
        ]
      },
      dist: {
        src: 'assets/css/global.css',
        dest: 'assets/css/global.min.css'
      }
    },

    // JsHint your javascript
    jshint: {
      all: ['assets/js/*.js', '!assets/js/*.min.js'],
      options: {
        jshintrc: 'assets/js/.jshintrc'
      }
    },

    // Uglify javascript
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - <%= pkg.author %> -' +
          '<%= grunt.template.today("yyyy-mm-dd") %> */'
      },
      dist: {
        files: [{
          expand: true,
          cwd: 'assets/js/',
          src: '*.js',
          dest: 'assets/js/',
          ext: '.min.js',
          extDot: 'first'
        }]
      }
    },


    // SVG min
    svgmin: {
      options: {
        plugins: [{
            convertPathData: false
          }, // breaks paths
          {
            mergePaths: false
          }, // breaks paths
          {
            removeUnknownsAndDefaults: false
          }, // breaks colors
          {
            removeViewBox: false
          },
          {
            removeUselessStrokeAndFill: false
          },
          {
            removeAttrs: {
              attrs: ['id', 'data-name']
            }
          }
        ]
      },
      dist: {
        files: [{
          expand: true,
          cwd: 'assets/svg/',
          src: '*.svg',
          dest: 'assets/images/',
          ext: '.svg',
          extDot: 'first'
        }]
      }
    },

    // Replace theme name in files
    replace: {
      style_replace: {
        src: ['style.css'],
        overwrite: true,
        replacements: [{
          from: /((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/,
          to: '/* \n' +
            'Theme Name: <%= pkg.name %> \n' +
            'Theme URI: http://www.<%= pkg.name %>.com \n' +
            'Author: <%= pkg.author %>\n' +
            'Author URI: http://www.catiadionisio.com/\n' +
            'Description:  <%= pkg.description %>\n' +
            'Version: <%= pkg.version %>\n' +
            'License: GNU General Public License v2 or later\n' +
            'License URI: http://www.gnu.org/licenses/gpl-2.0.html\n' +
            'Text Domain:\n' +
            'Tags:\n' +
            '*/'
        }]
      },
      bower_replace: {
        src: [
          'bower.json',
          'component.json'
        ],
        overwrite: true,
        replacements: [{
          from: 'YeoPress-Template',
          to: '<%= pkg.name %>'
        }]
      }
    },

  });

  // Default task
  grunt.registerTask('default', ['watch']);

  // CSS task
  grunt.registerTask('css_task', [
    'clean:css',
    'sass',
    'postcss'
  ]);

  // JS task
  grunt.registerTask('js_task', [
    'clean:js',
    'jshint',
    'uglify'
  ]);

  // SVG task
  grunt.registerTask('svg_task', [
    'svgmin:dist'
  ]);

  // Build task
  grunt.registerTask('build', function() {
    var arr = [];
    arr.push('css_task', 'js_task');

    return grunt.task.run(arr);
  });

  // Template Setup Task
  grunt.registerTask('setup', function() {
    var arr = [];
    arr.push('replace:style_replace', 'replace:bower_replace', 'bower-install', 'build');

    return grunt.task.run(arr);
  });

  // Load up tasks
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-postcss');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-svgmin');
  grunt.loadNpmTasks('grunt-text-replace');

  // Run bower install
  grunt.registerTask('bower-install', function() {
    var done = this.async();
    var bower = require('bower').commands;
    bower.install().on('end', function(data) {
      done();
    }).on('data', function(data) {
      console.log(data);
    }).on('error', function(err) {
      console.error(err);
      done();
    });
  });

};
