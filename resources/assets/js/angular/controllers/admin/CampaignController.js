adminControllers.controller('CampaignListController', ['$scope', '$http', '$routeParams', '$location',
    function ($scope, $http, $routeParams, $location) {
        $scope.page = 1;

        $scope.getRecords = function(page, search, search_by, order_by, order){
            $scope.page = typeof page !== 'undefined' ? page : $scope.page;
            $scope.search = typeof search !== 'undefined' ? search : '';
            $scope.search_by = typeof search_by !== 'undefined' ? search_by : 'id';
            $scope.order = typeof order !== 'undefined' ? order : 'asc';
            $scope.order_by = typeof order_by !== 'undefined' ? order_by : 'active';

            $http.get('/api/admin/campaigns/?page=' + $scope.page + '&search=' + $scope.search + '&search_by=' + $scope.search_by + '&order_by=' + $scope.order_by + '&order=' + $scope.order)
                .then(function successCallback(response) {
                    //console.log('successCallback: ');
                    //console.log(response);
                    $scope.campaigns = response.data.data;
                    $scope.totalItems = response.data.total;
                    $scope.currentPage = response.data.current_page;
                    $scope.maxSize = 10;
                }, function errorCallback(response) {
                    console.log('errorCallback: ');
                    console.log(response);
                    $scope.message = "Something goes wrong. For more info check console logs.";
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
adminControllers.controller('CampaignDetailController', ['$scope', '$http', '$routeParams',
    function ($scope, $http, $routeParams) {
        $scope.contestId = $routeParams.contestId;
        $http.get('/api/admin/contests/' + $routeParams.contestId).success(function(data) {
            $scope.contest = data.contest;
            $scope.reports = data.reports;
        });
    }]);
adminControllers.controller('CampaignCreateController', ['$scope', '$http', '$filter', '$location',
    function ($scope, $http, $filter, $location) {

        $http.get('/api/admin/campaigns/create')
            .then(function successCallback(response) {
                //console.log('successCallback: ');
                //console.log(response);
                $scope.campaign_categories = response.data.campaign_categories;
                $scope.countries = response.data.countries;
                $scope.networks = response.data.networks;
            }, function errorCallback(response) {
                console.log('errorCallback: ');
                console.log(response);
                $scope.message = "Something goes wrong. For more info check console logs.";
            });

        $scope.contest = {
            type: "top_earner",
            start_at: new Date(),
            end_at: new Date()
        };
        $scope.targets =  [
            { position: 1, name: '', description: '' },
            { position: 2, name: '', description: '' },
            { position: 3, name: '', description: '' }
        ];
        $scope.addTarget = function(){
            var position = $scope.rewards.length;
            $scope.rewards[position] = { position: position + 1, name: '', description: '' };
        };
        $scope.removeTarget = function(){
            $scope.rewards.pop();
        };
        $scope.create = function(campaign, targets) {
            var data = { campaign: campaign, targets: targets };

            $http.post('/api/admin/campaigns',
                data,
                { 'Content-Type': 'application/x-www-form-urlencoded' }
            ).then(function successCallback(response) {
                    console.log('successCallback: ');
                    console.log(response);
                    $scope.message = "Success";
                    //$location.url('campaigns');
                }, function errorCallback(response) {
                    console.log('errorCallback: ');
                    console.log(response);
                    $scope.message = "Something goes wrong. For more info check console logs.";
                });

        };
    }]);
adminControllers.controller('CampaignEditController', ['$scope', '$http', '$routeParams', '$filter','$httpParamSerializerJQLike', '$location',
    function ($scope, $http, $routeParams, $filter, $httpParamSerializerJQLike, $location) {
        $scope.contestId = $routeParams.contestId;
        $http.get('/api/admin/campaigns/' + $routeParams.contestId + '/edit').success(function(data) {
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

            $http.put('/api/admin/campaigns/' + $routeParams.contestId,
                data,
                { 'Content-Type': 'application/x-www-form-urlencoded' }
            ).then(function successCallback(response) {
                    //console.log('successCallback: ');
                    //console.log(response);
                    $scope.message = 'Success';
                    $location.path('campaigns/show/' + data.contest.id);
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


// adminControllers.controller('CampaignGalleryController', ['$scope', 'Upload', '$routeParams', function ($scope, Upload, $routeParams) {
//         // upload later on form submit or something similar
//         $scope.submit = function() {
//             if ($scope.form.files.$valid && $scope.files) {
//                 $scope.uploadFiles($scope.files);
//             }
//         };

//         // upload on file select or drop
//         // $scope.upload = function (file) {
//         //     Upload.upload({
//         //         url: '/admin/api/campaigns/gallery',
//         //         data: {file: file, 'campaignId': $routeParams.id}
//         //     }).then(function (resp) {
//         //         console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
//         //     }, function (resp) {
//         //         console.log('Error status: ' + resp.status);
//         //     }, function (evt) {
//         //         var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
//         //         console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
//         //     });
//         // };
//         // for multiple files:
//         $scope.uploadFiles = function (files) {
//             if (files && files.length) {
//                 for (var i = 0; i < files.length; i++) {
//                     Upload.upload({
//                         url: '/api/admin/campaigns/gallery',
//                         method: 'PUT',
//                         data: { file: files[i], 'campaignId': $routeParams.id }
//                     });
//                 }
//                 // or send them all together for HTML5 browsers:
//                 // Upload.upload({..., data: {file: files}, ...})...;
//             }
//         }
//     }]);