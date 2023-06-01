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
adminControllers.controller('SocialAccountListController', ['$scope', '$http', '$routeParams', '$location', '$httpParamSerializerJQLike',
    function ($scope, $http, $routeParams, $location, $httpParamSerializerJQLike) {
        $scope.page = $routeParams.page;
        $http.get('/api/admin/socialaccounts/?page=' + $routeParams.page).success(function(data) {
            $scope.socialaccounts = data.data;

            $scope.totalItems = data.total;
            $scope.currentPage = data.current_page;
            $scope.maxSize = 10;

        });

        $scope.pageChanged = function() {
            $location.path('/socialaccounts/' + $scope.currentPage);
        };

        $scope.orderProp = 'id';

        $scope.approval = function(id, status) {
            $http({
                method  : 'POST',
                url     : '/api/admin/socialaccounts/approval/' + id,
                data    : $httpParamSerializerJQLike({ approve: status }),
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
            })
                .success(function(data) {
                    // if successful, bind success message to message
                    for(var i = 0; i < $scope.socialaccounts.length; i++) {
                        if($scope.socialaccounts[i].account_id === id) {
                            $scope.socialaccounts[i].approved = status;
                            return true;
                        }
                    }
                });

        };

    }]);

adminControllers.controller('SocialAccountDetailController', ['$scope', '$http', '$routeParams', '$httpParamSerializerJQLike',
    function ($scope, $http, $routeParams, $httpParamSerializerJQLike) {
        $scope.socialId = $routeParams.socialId;
        $http.get('/api/admin/socialaccounts/' + $routeParams.socialId).success(function(data) {
            $scope.socialAccount = data;
        });

        $scope.approval = function(status) {
            $http({
                method  : 'POST',
                url     : '/api/admin/socialaccounts/approval/' + $routeParams.socialId,
                data    : $httpParamSerializerJQLike({ approve: status }),
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
            })
                .success(function(data) {
                    // if successful, bind success message to message
                    $scope.socialAccount.approved = status;
                });

        };
    }]);
adminControllers.controller('SocialPostsListController', ['$scope', '$http', '$routeParams', '$location', '$httpParamSerializerJQLike',
    function ($scope, $http, $routeParams, $location, $httpParamSerializerJQLike) {
        $scope.page = $routeParams.page;
        $http.get('/api/admin/socialposts/?page=' + $routeParams.page).success(function(data) {
            $scope.socialaccounts = data.data;

            $scope.totalItems = data.total;
            $scope.currentPage = data.current_page;
            $scope.maxSize = 10;

        });

        $scope.pageChanged = function() {
            $location.path('/socialposts/' + $scope.currentPage);
        };

        $scope.orderProp = 'id';

    }]);

adminControllers.controller('SocialPostsDetailController', ['$scope', '$http', '$routeParams', '$httpParamSerializerJQLike',
    function ($scope, $http, $routeParams, $httpParamSerializerJQLike) {
        $scope.igId = $routeParams.igId;
        $http.get('/api/admin/socialaccounts/' + $routeParams.igId).success(function(data) {
            $scope.ig = data;
        });
    }]);
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