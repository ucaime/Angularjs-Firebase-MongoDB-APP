'use strict';

/* jasmine specs for services go here */

describe('service', function() {
	beforeEach(module('myApp.services'));


	it("should return January when given 0 ", inject(function(calendarHelper) {
		expect(calendarHelper.getMonthName(0)).toBe('January');
		expect(calendarHelper.getMonthName(1)).not.toBe('January');
	}));

});