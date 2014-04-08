/**
 * services.js v1.0.0 by Sardor Isakov
 * Copyright 2013 Sardor Isakov
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * @name services
 *
 * @description
 * AngularJS module, services which are used in account page
 */
(function (document, angular, undifined) {
	'use strict';

	/* Services */
	angular.module('myApp.services', ['ngResource'])
	.factory('Content', ['$resource', 'myCache',function ($resource, myCache) {
		return $resource('account/ads/:id', 
		{id: '@_id'}, 
		{cache: myCache}, 
		{ 'save': { method: 'PUT'},
		'add': { method: 'POST'},
			'get': { method: 'GET'}
		});
	}])
	.factory('calendarHelper', [function () {
		var monthName = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		return {
			getCalendarDays: function (year, month) {
				var monthStartDate = new Date(year, month, 1);
				var days = [];
				for (var i = 0; i < monthStartDate.getDay(); i++) {
					days.push('');
				};
				for (var i = 0; i <= new Date(year, month + 1, 0).length; i++) {
					days.push(i);
				};
				return days;
			},
			getMonthName: function (monthNumber) {
				return monthName[monthNumber];
			}
		}
	}])
	.factory('Contact', function ($resource) {
		return $resource('contact/:name', 
			{name: '@clean_name'},
			{ 'save': {method: 'PUT'},
			  'add': {method: 'POST'},
			});
	})
	.factory('myCache', ['$cacheFactory',function ($cacheFactory) {
		return $cacheFactory('myCache', {
			capacity: 3
		});
	}])
	.factory('Phone', ['$http', '$resource', 'myCache', function ($http, $resource, myCache) {
		var Phone = $resource('account/ads/:id', {
			id: '@_id'
		});
		Phone.prototype.get = function (starshipQuery, successCb, failCb) {
			return Phone.get({
				id: starshipQuery
			}, successCb, failCb);
		};
		Phone.prototype.query = function (successCb, failCb) {
			return Phone.get(successCb, failCb);
		};
		return new Phone;
	}])
	.factory('myHttpInterceptor', ['$q', '$window', function ($q, $window) {
		return function (promise) {
			return promise.then(function (response) {
				// do something on success
				// todo hide the spinner
				$('#loading').hide();
				return response;
			}, function (response) {
				// do something on error
				// todo hide the spinner
				$('#loading').hide();
				return $q.reject(response);
			});
		};
	}]);

})(document, window.angular); // END (function () {}