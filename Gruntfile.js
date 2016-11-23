'use strict';
module.exports = function(grunt) {

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig({

		pkg: pkg,

		// js minification
		/*
		uglify: {
			dist: {
				files: {
					// admin scripts
					'lib/admin/js/min/timeline-express-admin.min.js': [ // all other admin scripts
						'lib/admin/js/bootstrap-select.js',
						'lib/admin/js/script.options-color-picker-custom.js',
					],
					// tinymce scripts
					'lib/admin/js/min/timeline-express-tinymce.min.js': [ // tinymce button script
						'lib/admin/js/timeline-express-button-script.js',
					],
					// public scripts
					'lib/public/js/min/timeline-express.min.js': [ // public scripts
						'lib/public/js/timeline-express.js',
					],
				}
			}
		},
		*/

		// Autoprefixer for our CSS files
		postcss: {
			options: {
				map: true,
				processors: [
					require( 'autoprefixer-core' ) ({
						browsers: [ 'last 2 versions' ]
					})
				]
			},
			dist: {
				src: [ 'lib/assets/css/*.css' ]
			}
		},

		// css minify all contents of our directory and add .min.css extension
		cssmin: {
			target: {
				files: [
					// Admin CSS files
					{
						'lib/assets/css/weather-icons-combined.min.css':
						[
							'lib/assets/css/weather-icons.css',
							'lib/assets/css/weather-icons-wind.css'
						],
					}
				]
			}
		},

		// Generate a nice banner for our css/js files
		usebanner: {
			taskName: {
				options: {
					position: 'top',
					replace: true,
					banner: '/*\n'+
						' * @Plugin <%= pkg.title %>\n' +
						' * @Author <%= pkg.author %>\n'+
						' * @Site <%= pkg.site %>\n'+
						' * @Version <%= pkg.version %>\n' +
						' * @Build <%= grunt.template.today("mm-dd-yyyy") %>\n'+
						' */',
					linebreak: true
				},
				files: {
					src: [
						'lib/assets/css/*.min.css',
					]
				}
			}
		},

		// watch our project for changes
		watch: {
			admin_css: { // admin css
				files: 'lib/assets/css/*.css',
				tasks: [ 'cssmin', 'usebanner' ],
				options: {
					spawn: false,
					event: ['all']
				},
			}
		},

		/*
		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: false
				},
				files: [
					{
						src: 'lib/admin/css/timeline-express-addons.css',
						dest: 'lib/admin/css/timeline-express-addons-rtl.css'
					},
					{
						src: 'lib/admin/css/timeline-express-settings.css',
						dest: 'lib/admin/css/timeline-express-settings-rtl.css'
					},
					{
						src: 'lib/admin/css/timeline-express-welcome.css',
						dest: 'lib/admin/css/timeline-express-welcome-rtl.css'
					},
					{
						src: 'lib/public/css/timeline-express-single-page.css',
						dest: 'lib/public/css/timeline-express-single-page-rtl.css'
					},
					{
						src: 'lib/public/css/timeline-express.css',
						dest: 'lib/public/css/timeline-express-rtl.css'
					}
				]
			}
		},
		*/

		makepot: {
			target: {
				options: {
					domainPath: 'i18n/',
					include: [ '.+\.php' ],
					exclude: [ 'node_modules/', 'bin/' ],
					potComments: 'Copyright (c) {year} Code Parrots. All Rights Reserved.',
					potHeaders: {
						'x-poedit-keywordslist': true
					},
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = pkg.bugs.url;
						return pot;
					},
					type: 'wp-plugin',
					updatePoFiles: true
				}
			}
		},

		po2mo: {
			files: {
				src: 'i18n/*.po',
				expand: true
			}
		},

		replace: {
			base_file: {
				src: [ 'weather-station-plus.php' ],
				overwrite: true,
				replacements: [{
					from: /Version: (.*)/,
					to: "Version: <%= pkg.version %>"
				}]
			},
			readme_txt: {
				src: [ 'readme.txt' ],
				overwrite: true,
				replacements: [{
					from: /Stable tag: (.*)/,
					to: "Stable tag: <%= pkg.version %>"
				}]
			},
			readme_md: {
				src: [ 'README.md' ],
				overwrite: true,
				replacements: [{
					from: /# Timeline Express - (.*)/,
					to: "# Weather Station Plus - <%= pkg.version %>"
				}]
			},
			constants: {
				src: [ 'constants.php' ],
				overwrite: true,
				replacements: [{
					from: /define\(\s*'WSP_VERSION',\s*'(.*)'\s*\);/,
					to: "define( 'WSP_VERSION', '<%= pkg.version %>' );"
				}]
			}
		},

	});

	// load tasks
	// grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-banner' );
	grunt.loadNpmTasks( 'grunt-postcss' ); // CSS autoprefixer plugin (cross-browser auto pre-fixes)
	// grunt.loadNpmTasks( 'grunt-cssjanus' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-po2mo' );
	grunt.loadNpmTasks( 'grunt-text-replace' );

	// register task
	grunt.registerTask( 'default', [
		// 'cssjanus',
		// 'uglify',
		'postcss',
		'cssmin',
		'usebanner'
	] );

	// register update-pot task
	grunt.registerTask( 'update-pot', [
		'makepot'
	] );

	// register update-mo task
	grunt.registerTask( 'update-mo', [
		'po2mo'
	] );

	// register update-translations
	grunt.registerTask( 'update-translations', [
		'makepot',
		'po2mo'
	] );

	// register bump-version
	grunt.registerTask( 'bump-version', [
		'replace',
	] );

};
