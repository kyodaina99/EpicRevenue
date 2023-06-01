adminControllers.controller('PublisherListController', ['$scope', '$http', '$routeParams', '$location',
    function ($scope, $http, $routeParams, $location) {
        $scope.page = 1;

        $scope.getRecords = function(page, search, search_by, order_by, order){
            $scope.page = typeof page !== 'undefined' ? page : $scope.page;
            $scope.search = typeof search !== 'undefined' ? search : '';
            $scope.search_by = typeof search_by !== 'undefined' ? search_by : 'id';
            $scope.order = typeof order !== 'undefined' ? order : 'dsc';
            $scope.order_by = typeof order_by !== 'undefined' ? order_by : 'id';

            if($routeParams.page == 'my'){
                $scope.my = true;
            } else {
                $scope.my = false;
            }
            if($routeParams.page == 'status'){
                $scope.status = true;
            } else {
                $scope.status = false;
            }

            $http.get('/api/admin/publishers/?status=' + $scope.status + '&page=' + $scope.page + '&my=' + $scope.my + '&search=' + $scope.search + '&search_by=' + $scope.search_by + '&order_by=' + $scope.order_by + '&order=' + $scope.order).success(function(data) {
                $scope.publishers = data.data;
                $scope.totalItems = data.total;
                $scope.currentPage = data.current_page;
                $scope.maxSize = 10;
            });

        };

        $scope.getRecords($scope.page);

        $scope.pageChanged = function() {
            $scope.page = $scope.currentPage;
            $scope.getRecords($scope.page, $scope.search, $scope.search_by, $scope.order_by, $scope.order);
        };

        $scope.searchRecords = function(query, search_by, order_by, order) {
            $scope.search = typeof query !== 'undefined' ? query : '';
            $scope.search_by = typeof search_by !== 'undefined' ? search_by : 'id';
            $scope.order = typeof order !== 'undefined' ? order : 'dsc';
            $scope.order_by = typeof order_by !== 'undefined' ? order_by : 'id';

            $scope.getRecords($scope.page, $scope.search, $scope.search_by, $scope.order_by, $scope.order);
        };
    }]);

adminControllers.controller('PublisherDetailController', ['$scope', '$http', '$routeParams', '$httpParamSerializerJQLike',
    function ($scope, $http, $routeParams, $httpParamSerializerJQLike) {
        $scope.userId = $routeParams.userId;
        $http.get('/api/admin/publishers/' + $routeParams.userId).success(function(data) {
            $scope.user = data;
        });

        $scope.approval = function(status) {
            $http({
                method  : 'POST',
                url     : '/api/admin/publishers/approval/' + $routeParams.userId,
                data    : $httpParamSerializerJQLike({ approve: status }),
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
            })
                .success(function(data) {
                    // if successful, bind success message to message
                    $scope.user.user.approved = status;
                });

        };
    }]);
adminControllers.controller('PublisherEditController', ['$scope', '$http', '$routeParams', '$httpParamSerializerJQLike',
    function ($scope, $http, $routeParams, $httpParamSerializerJQLike) {
        $scope.userId = $routeParams.userId;
        $http.get('/api/admin/publishers/' + $routeParams.userId + '/edit').success(function(data) {
            $scope.user = data;
        });

        $scope.update = function(user) {
            $http({
                method  : 'PUT',
                url     : '/api/admin/publishers/' + user.user.id,
                data    : $httpParamSerializerJQLike(user),
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
            })
                .success(function(data) {
                    // if successful, bind success message to message
                    $scope.message = data;
                });

        };
    }]);