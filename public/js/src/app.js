/**
 * app.js v1.0.0 by Sardor Isakov
 * Copyright 2013 uzlist.com
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * @name app
 *
 * @description
 * AngularJS module, app which are used in account page
 */
(function (document, angular, undifined) { 
    'use strict';

    Object.size = function(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };

    angular.module('myApp', ['ngRoute','myApp.filters', 'myApp.services', 'ngResource', 'myApp.directives', 'myApp.controllers', 'angularFileUpload']).
    config(['$routeProvider','$httpProvider', function($routeProvider, $httpProvider) {
        $routeProvider.when('/view/:id',{ controller: Single,       templateUrl: 'assets/account/accountView.html', resolve: Single.resolve});
        $routeProvider.when('/edit/:id',{ controller: 'EditCtrl',   templateUrl: 'assets/account/accountEdit.html' }    );
        $routeProvider.when('/new',     { controller: 'AddCtrl',    templateUrl: 'assets/account/accountNew.html'}        );
        $routeProvider.when('/',        { controller: 'MainCtrl',   templateUrl: 'assets/account/accountHome.html'}    );
        $routeProvider.when('/upload',  { controller: 'UploadCtrl', templateUrl: 'assets/image-upload.html'});
        $routeProvider.when('/contacts/view/:name', { controller:'ContactsSingleCTRL', templateUrl:'assets/contacts/contactsAddPage.html'});
        $routeProvider.when('/contacts/add', { controller: 'ContactsAddCTRL', templateUrl: 'assets/contacts/contactsAddPage.html'});
        $routeProvider.when('/contacts', { controller:'ContactsCTRL', templateUrl:'assets/contacts/contactsHomePage.html'});
        $routeProvider.when('/profile', { controller:'ProfileImageCTRL', templateUrl:'assets/profilePage.html'});


        $routeProvider.otherwise({redirectTo: '/'});

        $httpProvider.responseInterceptors.push('myHttpInterceptor');
            var spinnerFunction = function (data, headersGetter) {
                // todo start the spinner here
                $('#loading').show();
                return data;
        };
        $httpProvider.defaults.transformRequest.push(spinnerFunction);
    }])


    function Single($scope, $routeParams, datasets, myCache) {
        $scope.ad = datasets;
    };

    Single.resolve = {
        datasets : function($q, $route, $timeout, Phone) {
        var deferred = $q.defer();
        var name = $route.current.params.id;

        var successCb = function(result) {
            if(angular.equals(result, [])) {
                console.log("No starship found by that id");
                deferred.reject("Not found");
            } else {
                console.log("found");
                deferred.resolve(result);
                }
            };

            $timeout(function() {
                Phone.get($route.current.params.id, successCb);
                    //Phone.query(successCb);
            }, 200)

            return deferred.promise;
        }
    };

    angular.module('homeApp', ['firebase'])
    .controller('CommentsBoxCTRL', function ($scope, $http, $location, $firebase, ChatService) {
        var itemID = document.getElementById("post").getAttribute('data-item-id');
        var pushedItemId;
        console.log('CommentsBoxCTRL');
        $scope.comments = ChatService;
        $scope.hideSpinner=true;
        $scope.newComment = false;
        $scope.numOfNewComments=0;

        $scope.showCheckMark = true;
        $scope.timeX = '1393991888000';



        var loadedLength = 0;
        var numberOfComments = 0;
        $scope.comments.$on('change', function(){
            //console.log('change ' + numberOfComments)
            numberOfComments++;
        });
         $scope.comments.$on('loaded', function(data){
            loadedLength = Object.size(data)

            //console.log('loaded ' + loadedLength);
            $scope.hideSpinner=false;
        });
         var elementPosistion=0
        $scope.$on('COMMENT_HIDDEN', function(event,message) {
            elementPosistion = message;
            //console.log("NOTVISIBLE ------------ " + message)
            if(loadedLength <= numberOfComments) { // 5 < 6
                console.log("NEW **** " );
                $scope.newComment=true;
                $scope.numOfNewComments++;
            } 
        });
        $scope.goToComment = function() {
            window.scroll(0,elementPosistion );
            $scope.newComment = false;
            $scope.numOfNewComments=0;
        }




        $scope.submitComment = function () {
            $scope.showCheckMark = false;
            var data = {
                'comment': $scope.comment,
                'item_id': document.getElementById("post").getAttribute('data-item-id'),
            };
            $http.post('/api/comments', data).success(function (data) {
                
                pushedItemId = data.data._id.$id;
                data.data._id = data.data._id.$id;
                $scope.comment = '';
                $scope.comments.$add(data.data)
                loadedLength++;
                //commentsRef.push(data.data);
            });
            
        }
        $scope.keydown = function () {
            $scope.showCheckMark = true;
        };
    })
.factory("ChatService", ["$firebase", function($firebase) {
    var itemID = document.getElementById("post").getAttribute('data-item-id');
    var ref = new Firebase("https://sardor.firebaseio.com/" + itemID);
    return $firebase(ref);
  }])
    .directive('isVisible', function(){
        function viewport() {
            if (document.documentElement.clientHeight >= 0) {
                return document.documentElement.clientHeight;
            } else if (document.body && document.body.clientHeight >= 0) {
                return document.body.clientHeight
            } else if (window.innerHeight >= 0) {
                return window.innerHeight;
            } else {
                return 0;
            }
        }

        return {
            restrict: 'A',
            link: function (scope, element, attr) {

                var windowHeight = viewport();
                var elementPosistion = element[0].offsetTop;


                var documentHeight = window.innerHeight;
                var windowHeight = documentHeight;
                var scrollTop = 0;
                var topFoldOffset = scrollTop;
                var bottomFoldOffset = (topFoldOffset + windowHeight);
                var height = null;

                function isVisible(topFoldOffset, bottomFoldOffset) {
                        // If the element is not visible because it
                        // is hidden, don't bother testing it.
                        if (element.css('display') === 'none') {
                            //console.log("not visisble")
                            return (false);
                        }
                        // If the height has not yet been calculated,
                        // the cache it for the duration of the page.
                        if (height === null) {
                            height = element.height;
                        }
                        // Update the dimensions of the element.
                        var top = element[0].getBoundingClientRect().top;
                        var bottom = (top + height);
                        // Return true if the element is:
                        // 1. The top offset is in view.
                        // 2. The bottom offset is in view.
                        // 3. The element is overlapping the viewport.
                        return (
                            (
                                (top <= bottomFoldOffset) &&
                                (top >= topFoldOffset)
                            )
                        );
                }


                var v = '';
                if( ! isVisible(topFoldOffset, bottomFoldOffset)  ) {


                    scope.$emit('COMMENT_HIDDEN',elementPosistion);

                }
                console.log( isVisible(topFoldOffset, bottomFoldOffset) )
                
            }
        }
       
    })
     .directive('ifOffScreen', [

        function () {
            var element = '',
                scrollTop = 0,
                left = 0;

            function currentYPosition() {
                if (typeof pageYOffset != 'undefined')
                    return pageYOffset;
                if (document.documentElement && document.documentElement.scrollTop)
                    return document.documentElement.scrollTop;
                if (document.body.scrollTop)
                    return document.body.scrollTop;
                return 0;
            }

            function smoothScroll() {
                var startY = currentYPosition();
                var stopY = 0;

                var distance = stopY > startY ? stopY - startY : startY - stopY;
                var speed = Math.round(distance / 100);
                if (speed >= 15) speed = 15;
                var step = Math.round(distance / 25);
                var leapY = stopY > startY ? startY + step : startY - step;
                var timer = 0;
                for (var i = startY; i > stopY; i -= step) {
                    setTimeout("window.scrollTo(0, " + leapY + ")", timer * speed);
                    leapY -= step;
                    if (leapY < stopY) leapY = stopY;
                    timer++;
                }
            }

            function getOffset(el) {
                var _x = 0;
                while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
                    _x += el.offsetLeft - el.scrollLeft;
                    el = el.offsetParent;
                }
                return {
                    left: _x
                };
            }

            function addEvent(el, type, fn) {
                if (el.attachEvent) {
                    el.attachEvent && el.attachEvent('on' + type, fn);
                } else {
                    el.addEventListener(type, fn, false);
                }
            }

            function windowChanged(argument) {
                left = getOffset(document.getElementById('grid-wrapperX')).left;
                element.css('left', left - 70);
            }

            function scrollEvent() {
                scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;

                if (scrollTop > 400) {
                    element.css('visibility', 'visible')
                    element.addClass('fade');
                    left = getOffset(document.getElementById('grid-wrapperX')).left;
                    element.css('left', left - 70);
                } else {
                    element.removeClass('fade');
                    element.css('visibility', 'hidden')
                }
            }

            function link($scope, $element, $attrs) {
                element = $element;

                addEvent(window, 'scroll', scrollEvent);
                addEvent(window, 'resize', windowChanged);
                $element.bind('click', function () {
                    smoothScroll();
                });
            }

            return {
                restrict: 'AE',
                link: link
            }
        }
    ])



})(document, window.angular); // END (function () {}

 