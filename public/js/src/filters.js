/**
 * filters.js v1.0.0 by Sardor Isakov
 * Copyright 2013 Sardor Isakov
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * @name filters
 *
 * @description
 * AngularJS module, filters which are used in account page
 */
(function (document, angular, undifined) {
    'use strict';

    /* Filters */
    angular.module('myApp.filters', [])
    .filter('interpolate', ['version', function (version) {
        return function (text) {
            return String(text).replace(/\%VERSION\%/mg, version);
       }
    }])
    .filter('tel', function () {
        return function (tel) {
            if (!tel) {
                return '';
            }
            var value = tel.toString().trim().replace(/^\+/, '');
            if (value.match(/[^0-9]/)) {
                return tel;
            }
            var country, city, number;
            switch (value.length) {
            case 10: // +1PPP####### -> C (PPP) ###-####
                country = 1;
                city = value.slice(0, 3);
                number = value.slice(3);
                break;
            case 11: // +CPPP####### -> CCC (PP) ###-####
                country = value[0];
                city = value.slice(1, 4);
                number = value.slice(4);
                break;
            case 12: // +CCCPP####### -> CCC (PP) ###-####
                country = value.slice(0, 3);
                city = value.slice(3, 5);
                number = value.slice(5);
                break;
            default:
                return tel;
            }
            if (country == 1) {
                country = "";
            }
            number = number.slice(0, 3) + '-' + number.slice(3);
            return (country + " (" + city + ") " + number).trim();
        };
    })
    .filter('truncate', [function () {
        return function (text, length, end) {
            if (isNaN(length))
                length = 10;
            if (end === undefined)
                end = "...";
            if (text.length <= length || text.length - end.length <= length) {
                return text;
            } else {
                return String(text).substring(0, length - end.length) + end;
            }
        };
    }]);


})(document, window.angular); // END (function () {}