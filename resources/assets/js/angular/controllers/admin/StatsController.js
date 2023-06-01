adminControllers.controller('StatsController', ['$scope', '$http', '$interval', '$routeParams', '$rootScope',
    function($scope, $http, $interval, $routeParams, $rootScope) {

        $scope.getStats = function() {
            $http.get('/api/admin/stats').
                then(function (response) {
                    // this callback will be called asynchronously
                    // when the response is available
                    $scope.stats = response.data;
                }, function (response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                    $scope.stats = response.data;
                });
        };

        $scope.getStats(); // Get stats on start of page

        $scope.stop = $interval(operation, 10000);

        // Stop If location is changed
        var dereg = $rootScope.$on('$locationChangeSuccess', function() {
            $interval.cancel($scope.stop);
            dereg();
        });

        function operation() { $scope.getStats(); }

    }]);