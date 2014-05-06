'use strict';

wtc.app.controller('AuthCtrl', ['$scope', '$modal', function ($scope, $modal) {
    $scope.username = 'bb';

    $scope.open = function () {
        $modal.open({
            templateUrl: 'login.html',
            controller: 'ModalInstanceCtrl',
            backdrop: 'static'
        });
    }
}]);

wtc.app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', '$http', 'sessionStorage',
    function ($scope, $modalInstance, $http, sessionStorage) {
        $scope.create = false;
        $scope.login = true;

        $scope.accountInvalid = false;
        $scope.unknownError = false;

        $scope.account = {
            'username': '',
            'password': ''
        };
        $scope.newAccount = {
            'email': '',
            'username': '',
            'password': '',
            'confirmPassword': ''
        };

        $scope.showCreateAccount = function () {
            $scope.create = true;
            $scope.login = false;
        };

        $scope.showLogin = function () {
            $scope.login = true;
            $scope.create = false;
        };

        $scope.login = function () {
            $scope.account.client_id = wtc.secret.id;
            $scope.account.client_secret = wtc.secret.secret;
            $scope.account.grant_type = wtc.secret.type;
            $http({
                method: 'POST',
                url: wtc.urls.login,
                data: $scope.account
            }).success(function (data, status, headers, config) {
                // set headers for future requests
                if (data.access_token) {
                    $http.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token;
                    // save token for the current session
                    sessionStorage.setItem('token', data.access_token);
                    $modalInstance.close();
                } else {
                    $scope.unknownError = true;
                    $scope.accountInvalid = false;
                }
            }).error(function (data, status, headers, config) {
                $scope.accountInvalid = true;
                $scope.unknownError = false;
            });
        };

        $scope.createAccount = function () {
            console.log($scope.newAccount);
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    }]);

