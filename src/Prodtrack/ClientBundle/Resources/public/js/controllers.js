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

wtc.app.controller('MainCtrl', ['$scope', 'AuthService', function($scope, AuthService) {
    $scope.logout = function() {
        if (AuthService.isLoggedIn()) {
            AuthService.logout();
        }
    }
}]);

wtc.app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', 'AuthService',
    function ($scope, $modalInstance, AuthService) {
        $scope.create = false;
        $scope.login = true;

        $scope.accountInvalid = false;
        $scope.unknownError = false;

        $scope.account = AuthService.account;
        $scope.newAccount = AuthService.newAccount;

        $scope.showCreateAccount = function () {
            $scope.create = true;
            $scope.login = false;
        };

        $scope.showLogin = function () {
            $scope.login = true;
            $scope.create = false;
        };

        $scope.login = function () {
            var promise = AuthService.login($scope.account.username, $scope.account.password);
            promise.then(function () {
                $modalInstance.close();
            }, function (e) {
                if (e instanceof wtc.errors.InvalidCredentialsError) {
                    $scope.unknownError = false;
                    $scope.accountInvalid = true;
                }
                if (e instanceof wtc.errors.OAuthError) {
                    $scope.unknownError = true;
                    $scope.accountInvalid = false;
                }
            });
        };

        $scope.createAccount = function () {
            console.log($scope.newAccount);
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    }]);

