'use strict';

/* jasmine specs for controllers go here */

describe('controllers', function(){
	beforeEach(module('myApp.controllers'));


	it('should ....', inject(function() {
    //spec body
	}));

	it('should ....', inject(function() {
    //spec body
	}));

	it("and has a positive case ", function() {
		expect(true).toBe(true);
	});


	describe('EventListen', function(){
		var scope, $controllerConstructor,mockEventData;
		beforeEach(inject(function($controller, $rootScope) {
			scope = $rootScope.$new();
			mockEventData = sinon.stub({getAllEvents:function(){}});
			$controllerConstructor = $controller;
		}));

		it("should set the scope events to the result of eventDate.getAllEvents ", function() {

			var mockEvents = {};
			mockEventData.getAllEvents.returns(mockEvents);
			var ctrl = $controllerConstructor('EventListen', 
				{$scope:scope, $location:{}, eventData:mockEventData });
			expect(scope.events).toBe(mockEvents);
		});

		it("should set the scope navigateToDetails ", function() {
			var mocklocation = sinon.stub({url:function(){}});
			var ctrl = $controllerConstructor("EventListen",
				{$scope:scope, $location:mocklocation, eventData:mockEventData });
			var event = {id:23};

			scope.navigateToDetails(event);

			expect(mocklocation.url.calledWith('/event/23')).toBe(true);
		});
	});


});