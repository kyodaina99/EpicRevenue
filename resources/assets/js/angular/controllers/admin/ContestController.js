adminControllers.controller('ContestListController', ['$scope', '$http', '$routeParams', '$location',
    function ($scope, $http, $routeParams, $location) {
        $scope.page = $routeParams.page;

        var getRecords = function () {
            $http.get('/api/admin/contests/?page=' + $routeParams.page).success(function(data) {
                $scope.contests = data.data;

                $scope.totalItems = data.total;
                $scope.currentPage = data.current_page;
                $scope.maxSize = 10;
            });
        };

        getRecords();

        $scope.pageChanged = function() {
            $location.path('/contests/' + $scope.currentPage);
        };

        $scope.orderProp = 'id';

        $scope.delete = function(contest) {
            $http.delete('/api/admin/contests/' + contest.id)
            .success(function(data) {
                $scope.message = data;
                getRecords();
            });
        };
    }]);
adminControllers.controller('ContestDetailController', ['$scope', '$http', '$routeParams',
    function ($scope, $http, $routeParams) {
        $scope.contestId = $routeParams.contestId;
        $http.get('/api/admin/contests/' + $routeParams.contestId).success(function(data) {
            $scope.contest = data.contest;
            $scope.reports = data.reports;
        });
    }]);
adminControllers.controller('ContestCreateController', ['$scope', '$http', '$routeParams', '$filter','$httpParamSerializerJQLike', '$location',
    function ($scope, $http, $routeParams, $filter, $httpParamSerializerJQLike, $location) {
        $scope.contestId = $routeParams.contestId;
        $scope.contest = {
            type: "top_earner",
            start_at: new Date(),
            end_at: new Date()
        };
        $scope.rewards =  [
                { position: 1, name: '', description: '' },
                { position: 2, name: '', description: '' },
                { position: 3, name: '', description: '' }
            ];
        $scope.addReward = function(){
            var position = $scope.rewards.length;
            $scope.rewards[position] = { position: position + 1, name: '', description: '' };
        };
        $scope.removeReward = function(){
            $scope.rewards.pop();
        };
        $scope.create = function(contest, rewards) {
            var data = { contest: contest, rewards: rewards };

            $http.post('/api/admin/contests',
                data,
                { 'Content-Type': 'application/x-www-form-urlencoded' }
            ).then(function successCallback(response) {
                    //console.log('successCallback: ');
                    //console.log(response);
                    $scope.message = "Success";
                    $location.url('contests');
                    // this callback will be called asynchronously
                    // when the response is available
                }, function errorCallback(response) {
                    console.log('errorCallback: ');
                    console.log(response);
                    $scope.message = "Something goes wrong. For more info check console logs.";
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });

        };
    }]);
adminControllers.controller('ContestEditController', ['$scope', '$http', '$routeParams', '$filter','$httpParamSerializerJQLike', '$location',
    function ($scope, $http, $routeParams, $filter, $httpParamSerializerJQLike, $location) {
        $scope.contestId = $routeParams.contestId;
        $http.get('/api/admin/contests/' + $routeParams.contestId + '/edit').success(function(data) {
            data.start_at = new Date(data.start_at);
            data.end_at = new Date(data.end_at);
            $scope.contest = data;
            $scope.rewards = data.rewards;
        });

        $scope.addReward = function(){
            var position = $scope.rewards.length;
            $scope.rewards[position] = { position: position + 1, name: '', description: '' };
        };
        $scope.removeReward = function(){
            $scope.rewards.pop();
        };

        $scope.update = function(contest, rewards) {
            var data = { contest: contest, rewards: rewards };

            $http.put('/api/admin/contests/' + $routeParams.contestId,
                data,
                { 'Content-Type': 'application/x-www-form-urlencoded' }
            ).then(function successCallback(response) {
                    //console.log('successCallback: ');
                    //console.log(response);
                    $scope.message = 'Success';
                    $location.path('contests/show/' + data.contest.id);
                    // this callback will be called asynchronously
                    // when the response is available
                }, function errorCallback(response) {
                    console.log('errorCallback: ');
                    console.log(response);
                    $scope.message = "Something goes wrong. For more info check console logs.";
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
        };
    }]);