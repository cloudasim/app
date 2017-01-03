module.exports = function( grunt ){
    
    // Project Configuration Here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        //sass compile
        sass: {
            dist: {
                options: {
                    style: 'compact'
                },
                files: {
                    './assets/src/css/main.css': './assets/src/scss/main.scss'
                }
            }
        },
        
        //js and css concat
        concat: {
            options:{
                separator:"\n \n /*** New File ***/ "
            },
            js: { 
                src: [ 
                    './node_modules/jquery/dist/jquery.min.js',
                    './node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
                    './assets/src/js/script.js'
                ],
                dest: './assets/dist/js/script.js'
            },
             css: {
                src: [
                     './assets/src/css/main.css'
                ],
                
                dest: './assets/src/css/main.css'
             }
            
        },

        //js minify
        uglify: {
            options: {
                report: 'gzip'
            },
            main: {
                src: ['./assets/dist/js/script.js'],
                dest: './assets/dist/js/script.min.js'
            }
        },

        //css minify
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1,
                keepSpecialComments : 0,
                sourceMap: false
            },
            target: {
                files: [{
                    expand: true,
                    cwd: './assets/src/css/',
                    src: ['*.css', '!*.min.css'],
                    dest: './assets/dist/css/',
                    ext: '.min.css'
                }]
            }
        },

        //copy content
        copy: {
            main: {
              files: [
                    { expand: true, cwd: './assets/src/img', src: '**', dest: './assets/dist/img/', filter: 'isFile'},
                    { expand: true, cwd: './assets/src/css', src: '*.css', dest: './assets/dist/css/', filter: 'isFile'}
              ]
          }
        },
        
        // Watch Changes
        watch: {
            js : {
                files : ['./assets/src/js/*.js', './assets/src/js/**/*.js'],
                tasks : [ 'js' ]
            },
            css : {
                files : [
                    './assets/src/scss/*.scss',
                    './assets/src/scss/**/**/**/*.scss',
                    './assets/src/scss/**/**/*.scss',
                    './assets/src/scss/**/*.scss'
                    ],
                tasks : [ 'css']
            }
        } 

    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-sass');
  
    // Grunt Tasks
    grunt.registerTask( 'css', [ 'sass', 'concat', 'cssmin', 'copy'] );
    grunt.registerTask( 'js', [ 'concat', 'uglify', 'copy' ] );
    grunt.registerTask('default', [ 'sass', 'concat', 'copy', 'uglify','cssmin'] );
}