wtc.app.run(['AuthService', function appRun(AuthService) {
    AuthService.setTokenHeader();
}]);

// sessionStorage wrapper
wtc.app.factory('sessionStorage', ['$window', function sessionStorageDef($window) {
    var setItem = function (key, value) {
        $window.sessionStorage.setItem(key, value);
    };
    var getItem = function (key) {
        return $window.sessionStorage.getItem(key);
    };

    return {
        setItem: setItem,
        getItem: getItem
    };
}]);


wtc.app.factory('AuthService',
    ['$modal', '$http', 'sessionStorage', '$q', function AuthServiceDef($modal, $http, sessionStorage, $q) {
        var newAccount = {
            'email': '',
            'username': '',
            'password': '',
            'confirmPassword': ''
        };

        var account = {
            'username': '',
            'password': ''
        };

        var authPrompt = function () {
            $modal.open({
                templateUrl: 'login.html',
                controller: 'ModalInstanceCtrl',
                backdrop: 'static'
            });
        };

        var doLogin = function (username, password) {
            var deferred = $q.defer();
            var authData = {
                'username': username,
                'password': password,
                'client_id': wtc.secret.id,
                'client_secret': wtc.secret.secret,
                'grant_type': wtc.secret.type
            };
            // use a promise here
            $http({
                method: 'POST',
                url: wtc.urls.login,
                data: authData
            }).success(function (data, status, headers, config) {
                // set headers for future requests
                if (data.access_token) {
                    $http.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token;
                    // save token for the current session
                    sessionStorage.setItem('token', data.access_token);
                    deferred.resolve();
                } else {
                    deferred.reject(new wtc.errors.OAuthError());
                }
            }).error(function () {
                deferred.reject(new wtc.errors.InvalidCredentialsError());
            });
            return deferred.promise;
        };

        var createAccount = function (email, username, password) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: wtc.urls.createAccount,
                data: {}
            }).success(function (data) {

            }).error(function(){
                deferred.reject(new wtc.errors.InvalidCredentialsError());
            });
            return deferred.promise;
        };

        var isLoggedIn = function() {
            return !!$http.defaults.headers.common['Authorization'];
        };

        var setTokenHeader = function() {
            var token = sessionStorage.getItem('token');
            if (token) {
                $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            } else {
                authPrompt();
            }
        }

        return {
            newAccount: newAccount,
            account: account,
            prompt: authPrompt,
            login: doLogin,
            createAccount: createAccount,
            setTokenHeader: setTokenHeader,
            isLoggedIn: isLoggedIn
        };
    }]);

wtc.app.factory('Entry', [function () {
    // call api root
    // get relevant 'rels'
    return {};
}]);