basePath = '../../';

files = [
  JASMINE,
  JASMINE_ADAPTER,
  'vendor/angular.js',
  'vendor/angular-*.js',
  'karma/test/lib/angular/angular-mocks.js',
  'karma/test/lib/angular/sinon.js',
  'src/**/*.js',
  'karma/test/unit/**/*.js'
];

autoWatch = true;

browsers = ['Chrome'];

junitReporter = {
  outputFile: 'test_out/unit.xml',
  suite: 'unit'
};
