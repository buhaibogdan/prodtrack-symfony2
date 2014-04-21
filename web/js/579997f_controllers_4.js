'use strict';

wtc.app.controller('AuthCtrl', ['$scope', '$modal', function ($scope, $modal) {
    $scope.username = 'bb';

    $scope.open = function () {
        $modal.open({
            templateUrl: 'login.html',
            controller: 'ModalInstanceCtrl'
        });
    }
}]);

wtc.app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', '$http',
    function($scope, $modalInstance, $http){
        $scope.create = false;
        $scope.login = true;

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

        $scope.showCreateAccount = function() {
            $scope.create = true;
            $scope.login = false;
        };

        $scope.showLogin = function() {
            $scope.login = true;
            $scope.create = false;
        };

        $scope.login = function () {
            //$modalInstance.close($scope.selected.item);
            console.log($scope.account);
            $http({
                method: 'POST',
                url: wtc.urls.login,
                data: $scope.account}
            ).success(function(data, status, headers, config) {
                // this callback will be called asynchronously
                // when the response is available
                console.log(data);
                console.log(headers);
            }).error(function(data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });

        };

        $scope.createAccount = function() {
            console.log($scope.newAccount);
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
}]);

