'use strict';

describe('Controller: EditoraCtrl', function () {

  // load the controller's module
  beforeEach(module('frontendApp'));

  var EditoraCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    EditoraCtrl = $controller('EditoraCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(EditoraCtrl.awesomeThings.length).toBe(3);
  });
});
