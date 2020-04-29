module.exports = function(grunt) {
  'use strict';

  // Load all tasks
  require('load-grunt-tasks')(grunt);
  // Show elapsed time
  require('time-grunt')(grunt);

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  // Find what the current theme's directory is, relative to the WordPress root
  var path = process.cwd().replace(/^[\s\S]+\/wp-content/, "\/wp-content");

  var cssLessFiles = {
    'css/child-style.css': 'less/style.less',
    'homepages/assets/css/homepage.css': 'homepages/assets/less/homepage.less'
  };

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    less: {
      compile: {
        options: {
          paths: [
            'less'
          ],
          outputSourceFiles: true,
          sourceMapBasepath: path,
          compress: true
        },
        files: cssLessFiles
      }
    },

    shell: {
      msgmerge: {
        command: [
          'msgmerge -o lang/es_ES.po.merged lang/es_ES.po lang/caribbean.pot',
          'mv lang/es_ES.po.merged lang/es_ES.po'
        ].join('&&')
      },
      pot: {
        command: [
          'wp i18n make-pot . lang/largo.pot'
        ].join('&&'),
        options: {
          stdout: true
        }
      },
    },

    watch: {
      less: {
        files: [
          'less/*.less',
          'homepages/assets/less/*.less',
        ],
        tasks: [
          'less:compile',
        ]
      }
    },

    po2mo: {
      files: {
        src: 'lang/*.po',
        expand: true
      }
    }

  });

  // Build assets, docs and language files
  grunt.registerTask('default', 'Build less files', [
    'less',
    'shell:pot',
    'shell:msgmerge',
    'po2mo'
  ]);
}
