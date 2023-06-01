adminControllers.controller('ReportListController', ['$scope', '$http', '$routeParams', '$location',
    function ($scope, $http, $routeParams, $location) {
        $scope.page = 1;

        $scope.getRecords = function(page, search, search_by, order_by, order){
            $scope.page = typeof page !== 'undefined' ? page : $scope.page;
            $scope.search = typeof search !== 'undefined' ? search : '';
            $scope.search_by = typeof search_by !== 'undefined' ? search_by : 'reports.id';
            $scope.order = typeof order !== 'undefined' ? order : 'dsc';
            $scope.order_by = typeof order_by !== 'undefined' ? order_by : 'reports.id';

            $http.get('/api/admin/reports/?page=' + $scope.page + '&search=' + $scope.search + '&search_by=' + $scope.search_by + '&order_by=' + $scope.order_by + '&order=' + $scope.order).success(function(data) {
                $scope.reports = data.data;
                $scope.totalItems = data.total;
                $scope.currentPage = data.current_page;
                $scope.maxSize = 10;
                $scope.itemsPerPage = data.per_page;
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


        $scope.update = function(id, status) {
            var data = {status: status};

            $http.put('/api/admin/reports/' + id,
                data,
                {'Content-Type': 'application/x-www-form-urlencoded'}
            ).then(function successCallback(response) {
                    $scope.message = 'success';
                    for(var i = 0; i < $scope.reports.length; i++) {
                        if($scope.reports[i].id === id) {
                            $scope.reports[i].status = parseInt( response.data );
                            return true;
                        }
                    }
                }, function errorCallback(response) {
                    console.log('errorCallback: ');
                    console.log(response);
                    $scope.message = "Something goes wrong. For more info check console logs.";
                });
        };


        $scope.destroy = function(id) {
            $http.delete('/api/admin/reports/' + id).then(function successCallback(response) {
                if(response.data == 'success') {
                    for(var i = 0; i < $scope.reports.length; i++) {
                        if($scope.reports[i].id === id) {
                            $scope.getRecords($scope.page);
                            return true;
                        }
                    }
                }
            }, function errorCallback(response) {
                console.log('errorCallback: ');
                console.log(response);
                $scope.message = "Something goes wrong. For more info check console logs.";
            });
        };

    }]);

adminControllers.controller('ReportDetailController', ['$scope', '$http', '$routeParams', '$location',
    function ($scope, $http, $routeParams, $location) {
        $scope.reportId = $routeParams.reportId;
        $http.get('/api/admin/reports/' + $routeParams.reportId).success(function(data) {
            $scope.report = data;
        });

        $scope.update = function(id, status) {
            var data = {status: status};

            $http.put('/api/admin/reports/' + id,
                data,
                {'Content-Type': 'application/x-www-form-urlencoded'}
            ).then(function successCallback(response) {
                    $scope.message = 'success';
                    $scope.report.status = parseInt( response.data );
                }, function errorCallback(response) {
                    console.log('errorCallback: ');
                    console.log(response);
                    $scope.message = "Something goes wrong. For more info check console logs.";
                });
        };

        $scope.destroy = function(id) {
            $http.delete('/api/admin/reports/' + id).then(function successCallback(response) {
                if(response.data == 'success') {
                    $location.url('reports');
                }
            }, function errorCallback(response) {
                console.log('errorCallback: ');
                console.log(response);
                $scope.message = "Something goes wrong. For more info check console logs.";
            });
        };
    }]);