'use strict'
// wtc from work track client
var wtc = wtc|| {};
wtc.app = angular.module('WorkTrackClient', ['ui.bootstrap']);

wtc.app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    }
);

wtc.urls = {
    'login': '/app_dev.php/account/login',
    'logout': '/app_dev.php/account/logout',
    'createAccount': '/app_dev.php/account/create'
};