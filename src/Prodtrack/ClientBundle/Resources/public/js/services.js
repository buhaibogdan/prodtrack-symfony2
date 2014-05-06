
// sessionStorage wrapper
wtc.app.factory('sessionStorage', ['$window', function sessionStorageProvider($window){
    var setItem = function(key, value) {
        $window.sessionStorage.setItem(key, value);
    };
    var getItem = function(key) {
        return $window.sessionStorage.getItem(key);
    };

    return {
        setItem: setItem,
        getItem: getItem
    };
}]);


wtc.app.run(['$http', 'sessionStorage', function appRun($http, sessionStorage) {
    var token = sessionStorage.getItem('token');
    if (token) {
        $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    }
}]);