'use strict'
// wtc from work track client
var wtc = wtc || {};
wtc.urls = {
    'login': '/app_dev.php/oauth/token',
    'logout': '/app_dev.php/account/logout',
    'createAccount': '/app_dev.php/account/create'
};

wtc.app = angular.module('WorkTrackClient', ['ui.bootstrap'], ['$httpProvider', function ($httpProvider) {
    // Use x-www-form-urlencoded Content-Type
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    // Override $http service's default transformRequest
    $httpProvider.defaults.transformRequest = [function (data) {
        return angular.isObject(data) &&
            String(data) !== '[object File]' ? wtc.utils.params(data) : data;
    }];
}]);

wtc.app.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}]);

// the wtc.utils "namespace" is used to keep useful functions|objects
// that can be used through the entire application
// maybe transform this into a provider
wtc.utils = {};
wtc.utils.params = function (obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

    for (name in obj) {
        value = obj[name];

        if (value instanceof Array) {
            for (i = 0; i < value.length; ++i) {
                subValue = value[i];
                fullSubName = name + '[' + i + ']';
                innerObj = {};
                innerObj[fullSubName] = subValue;
                query += wtc.utils.params(innerObj) + '&';
            }
        }
        else if (value instanceof Object) {
            for (subName in value) {
                subValue = value[subName];
                fullSubName = name + '[' + subName + ']';
                innerObj = {};
                innerObj[fullSubName] = subValue;
                query += wtc.utils.params(innerObj) + '&';
            }
        }
        else if (value !== undefined && value !== null)
            query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }

    return query.length ? query.substr(0, query.length - 1) : query;
};

// secret stuff
wtc.secret = {
    id:'a9df6c5b72622dbea463ad1a1ba774425efc7eea',
    secret:'871c85109d7563735565d0b9c044432d3755c5c5',
    type: 'password'
};