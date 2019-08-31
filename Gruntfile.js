module.exports = function ( grunt ) {

    require( 'load-grunt-tasks' )( grunt );

    var conf = {
        plugin_branches: {
            include_files: [
                'app/assets/css/**',
                'app/assets/js/**',
                'app/assets/images/**',
                'core/**',
                'gamos-plugin.php',
            ]
        },

        plugin_dir: 'gamos-plugin/',
        plugin_file: 'gamos-plugin.php'
    };

    // Project configuration.
    grunt.initConfig( {

        pkg: grunt.file.readJSON( 'package.json' ),

        // Make .pot file for translation.
        makepot: {
            options: {
                domainPath: 'languages',
                exclude: [
                    'vendor/.*'
                ],
                mainFile: 'gamos-plugin.php',
                potFilename: 'gamos-plugin.pot',
                potHeaders: {
                    'poedit': true,
                    'language-team': 'Joel James <me@joelsays.com>',
                    'report-msgid-bugs-to': 'https://duckdev.com/',
                    'last-translator': 'Joel James <me@joelsays.com>',
                    'x-generator': 'grunt-wp-i18n'
                },
                type: 'wp-plugin',
                updateTimestamp: false, // Update POT-Creation-Date header if no other changes are detected.
                cwd: ''
            },
            // Make .pot file for the plugin.
            main: {
                options: {
                    cwd: ''
                }
            },
            // Make .pot file for the release.
            release: {
                options: {
                    cwd: 'releases/gamos-plugin'
                }
            }
        },

        // Make .mo file from .pot file for translation.
        po2mo: {
            // Make .mo file for the plugin.
            main: {
                src: 'languages/gamos-plugin.pot',
                dest: 'languages/gamos-plugin.mo'
            },
            // Make .mo file for the release.
            release: {
                src: 'releases/gamos-plugin/languages/gamos-plugin.pot',
                dest: 'releases/gamos-plugin/languages/gamos-plugin.mo'
            }
        },

        jshint: {
            files: [
                'app/assets/src/js/**/*.js'
            ],
            options: {
                expr: true,
                globals: {
                    jQuery: true,
                    console: true,
                    module: true,
                    document: true
                }
            }
        },
        sass: {
            all: {
                options: {
                    style: 'compressed',
                    'sourcemap=none': true
                },
                files: {
                    'app/assets/css/front.min.css': 'app/assets/src/scss/front.scss',
                    'app/assets/vendor/magnific-popup/css/magnific-popup.min.css': 'app/assets/vendor/magnific-popup/css/magnific-popup.css'
                }
            }
        },
        uglify: {
            all: {
                options: {
                    report: 'gzip'
                },
                files: {
                    'app/assets/js/front.min.js': 'app/assets/src/js/front.js',
                }
            }
        },

        // Clean temp folders and release copies.
        clean: {
            temp: {
                src: [
                    '**/*.tmp',
                    '**/.afpDeleted*',
                    '**/.DS_Store',
                ],
                dot: true,
                filter: 'isFile'
            },
            folder_v2: [
                'releases/**',
                'app/assets/css/**',
                'app/assets/js/**'
            ],
        },

        // Verify in text domain is used properly.
        checktextdomain: {
            options: {
                text_domain: 'gamos-plugin',
                keywords: [
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,4d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d'
                ]
            },
            files: {
                src: [
                    'core/**/*.php',
                    'app/templates/**/*.php',
                    'gamos-plugin.php'
                ],
                expand: true
            }
        },

        // Copy selected folder and files for release.
        copy: {
            files: {
                src: conf.plugin_branches.include_files,
                dest: 'releases/<%= pkg.name %>/'
            }
        },

        // Compress release folder with version number.
        compress: {
            files: {
                options: {
                    mode: 'zip',
                    archive: './releases/<%= pkg.name %>-<%= pkg.version %>.zip'
                },
                expand: true,
                cwd: 'releases/<%= pkg.name %>/',
                src: ['**/*'],
                dest: conf.plugin_dir
            }
        }
    } );

    // Check if text domain is used properly.
    grunt.registerTask( 'prepare', ['checktextdomain'] );

    // Make pot file from files.
    grunt.registerTask( 'translate', ['makepot:main', 'po2mo:main'] );

    // Compile and generate assets.
    grunt.registerTask( 'compile', [
        'jshint',
        'uglify',
        'sass'
    ] );

    // Run build task to create release copy.
    grunt.registerTask( 'build', 'Run all tasks.', function () {
        grunt.task.run( 'clean' );
        grunt.task.run( 'translate' );
        grunt.task.run( 'compile' );
        grunt.task.run( 'copy' );
        grunt.task.run( 'makepot:release' );
        grunt.task.run( 'po2mo:release' );
        grunt.task.run( 'compress' );
    } );
};