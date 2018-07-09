'use strict';
module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Watches for changes and runs tasks
		watch : {
			less : {
				files : ['assets/less/*.less'],
				tasks : ['css_task']
			},
			css : {
				files : ['assets/css/**/*.css'],
				options : {
					livereload : true
				}
			},
			js : {
				files : ['assets/js/**/*.js', '!assets/js/**/*.min.js'],
				tasks : ['js_task'],
				options : {
					livereload : true
				}
			},
			php : {
				files : ['**/*.php'],
				options : {
					livereload : true
				}
			}
		},

		// Clean minified css and js
		clean: {
			css: {
				src: ['assets/css/global.min.css']
			},
			js: {
				src: ['assets/js/scripts.min.js']
			},
		},

		// Compile less files into CSS
		less: {
		  production: {
		    options: {
		      paths: ['assets/less']
		    },
		    files: {
		      'assets/css/global.css': 'assets/less/*.less'
		    }
		  }
		},

		// Apply post-processors to CSS - autoprefixer and minify
		postcss: {
	    options: {
	      map: true, // inline sourcemaps
	      processors: [
	        require('autoprefixer')({browsers: 'last 2 versions'}), // add vendor prefixes
	        require('cssnano')({preset: 'default'}) // minify the result
	      ]
	    },
	    dist: {
	      src: 'assets/css/global.css',
				dest: 'assets/css/global.min.css'
	    }
	  },

		// JsHint your javascript
		jshint : {
			all : ['assets/js/*.js', '!assets/js/*.min.js'],
			options : {
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
				src: 'assets/js/scripts.js',
				dest: 'assets/js/scripts.min.js'
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

		// Image min
		imagemin : {
			production : {
				files : [
					{
						expand: true,
						cwd: 'images',
						src: '**/*.{png,jpg,jpeg}',
						dest: 'images'
					}
				]
			}
		},

		// SVG min
		svgmin: {
			production : {
				files: [
					{
						expand: true,
						cwd: 'images',
						src: '**/*.svg',
						dest: 'images'
					}
				]
			}
		},

		"bower-install-simple": {
        options: {
            color: true,
            directory: "assets/vendor"
        },
        "prod": {
            options: {
                production: true
            }
        },
        "dev": {
            options: {
                production: false
            }
        }
    }

	});

	// Default task
	grunt.registerTask('default', ['watch']);

	// CSS task
	grunt.registerTask( 'css_task', [
		'clean:css',
		'less',
		'postcss'
	]);

	// JS task
	grunt.registerTask( 'js_task', [
		'clean:js',
		'jshint',
		'uglify'
	]);

	// Build task
	grunt.registerTask('build', function() {
		var arr = [];
		arr.push('css_task', 'js_task', 'imagemin:production', 'svgmin:production', 'bower-install-simple');

		return grunt.task.run(arr);
	});

	// Template Setup Task
	grunt.registerTask('setup', function() {
		var arr = [];
		arr.push('replace:style_replace', 'replace:bower_replace', 'bower-install', 'build');

		return grunt.task.run(arr);
	});

	// Load up tasks
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-postcss');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-text-replace');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-svgmin');
	grunt.loadNpmTasks("grunt-bower-install-simple");

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
