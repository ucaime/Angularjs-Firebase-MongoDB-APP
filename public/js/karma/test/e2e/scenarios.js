'use strict';

/* http://docs.angularjs.org/guide/dev_guide.e2e-testing */

describe('my app', function() {

	beforeEach(function() {
		browser().navigateTo('../../../login');
	});


	it('should render view1 when user navigates to /view1', function() {
		expect(element('h1:first').text()).
		toMatch(/Login/);
	});

	describe('account', function() {

		beforeEach(function() {
			browser().navigateTo('/account');
		});


		it('should render account when user navigates to /account', function() {
			expect(element('h1:first').text()).toMatch(/My/);
		});  


	});




});
