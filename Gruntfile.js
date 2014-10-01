module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
        less: {
            development: {
                options: {
                    compress: true  //minifying the result
                },
                files: {
                    "./public/css/bootstrap.css"        : "./public/less/bootstrap.less",
                    "./public/css/laravel-admin.css"    : "./public/less/laravel-admin.less",
                    "./public/css/font-awesome.css"     : "./public/less/font-awesome.less",
                    "./public/css/db_bootstrap.css"     : "./public/less/db_bootstrap.less"
                }
            }
        },
        concat: {
            options: {
                separator: ';'
            },
            js: {
                src: [
                    './public/js/core/jquery.js',
                    './public/js/core/bootstrap.js',
                    './public/js/core/app.js',
                ],
                dest: './public/js/core.jquery.js'
            },
            datatables: {
                src: [
                    './public/js/core/jquery.datatables.min.js',
                    './public/js/core/datatables.js'
                ],
                dest: './public/js/core.datatables.js'
            },
            themejs: {
                src: [
                    './public/js/core/theme/metisMenu/metisMenu.min.js',
                    './public/js/core/theme/sb-admin-2.js'
                ],
                dest: './public/js/theme.js'
            }
        },
        uglify: {
			options: {
				mangle: true
			},
			dist: {
				files: {
                    './public/js/core.jquery.js'         : './public/js/core.jquery.js',
                    './public/js/core.datatables.js'     : './public/js/core.datatables.js',
                    './public/js/theme.js'               : './public/js/theme.js'
				}
			}
		},
        /*cssmin: {
            combine: {
                files: {
                    './public/css/basic-theme.css': [
                        './public/cssTemp/neon-core.css',
                        './public/cssTemp/neon-forms.css',
                        './public/cssTemp/neon-theme.css',
                        './public/cssTemp/white-skins.css',
                    ]
                }
            }
        },*/
        watch: {
            less: {
                files: ['./public/**/*.less'],
                tasks: ['less'],
                options: {
                    livereload: true
                }
            },
            dist: {
				files: ['./public/js/core/app.js'],
				tasks: ['concat', 'uglify'],
				options: {
					livereload: true
				}
			}
        }
	});

	// Plugin loading
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    //grunt.loadNpmTasks('grunt-contrib-cssmin');

    // Task definition
	grunt.registerTask('build', ['less', 'concat', 'uglify']);
	grunt.registerTask('default', ['build','watch']);
}
