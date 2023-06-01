app.config(['$interpolateProvider', '$routeProvider',
    function($interpolateProvider, $routeProvider) {

        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

        $routeProvider.
            when('/stats', {
                templateUrl: '/build/assets/js/partials/admin/stats.html',
                controller: 'StatsController'
            }).
            when('/publishers/:page?', {
                templateUrl: '/build/assets/js/partials/admin/publishers/index.html',
                controller: 'PublisherListController'
            }).
            when('/publishers/show/:userId', {
                templateUrl: '/build/assets/js/partials/admin/publishers/show.html',
                controller: 'PublisherDetailController'
            }).
            when('/publishers/edit/:userId', {
                templateUrl: '/build/assets/js/partials/admin/publishers/edit.html',
                controller: 'PublisherEditController'
            }).
            when('/socialaccounts/:page?', {
                templateUrl: '/build/assets/js/partials/admin/socialaccounts/index.html',
                controller: 'SocialAccountListController'
            }).
            when('/contests/create/', {
                templateUrl: '/build/assets/js/partials/admin/contests/create.html',
                controller: 'ContestCreateController'
            }).
            when('/socialaccounts/show/:socialId/', {
                templateUrl: '/build/assets/js/partials/admin/socialaccounts/show.html',
                controller: 'SocialAccountDetailController'
            }).
            when('/contests/:page?', {
                templateUrl: '/build/assets/js/partials/admin/contests/index.html',
                controller: 'ContestListController'
            }).
            when('/contests/show/:contestId', {
                templateUrl: '/build/assets/js/partials/admin/contests/show.html',
                controller: 'ContestDetailController'
            }).
            when('/contests/edit/:contestId', {
                templateUrl: '/build/assets/js/partials/admin/contests/edit.html',
                controller: 'ContestEditController'
            }).
            when('/reports/:page?', {
                templateUrl: '/build/assets/js/partials/admin/reports/index.html',
                controller: 'ReportListController'
            }).
            // when('/campaigns/gallery/:id?', {
            //     templateUrl: '/build/assets/js/partials/admin/campaigns/gallery.html',
            //     controller: 'CampaignGalleryController'
            // }).
            when('/campaigns/create', {
                templateUrl: '/build/assets/js/partials/admin/campaigns/create.html',
                controller: 'CampaignCreateController'
            }).
            when('/campaigns/:page?', {
                templateUrl: '/build/assets/js/partials/admin/campaigns/index.html',
                controller: 'CampaignListController'
            }).
            when('/reports/show/:reportId', {
                templateUrl: '/build/assets/js/partials/admin/reports/show.html',
                controller: 'ReportDetailController'
            }).
            when('/campaigns/show/:campaignId', {
                templateUrl: '/build/assets/js/partials/admin/campaigns/show.html',
                controller: 'CampaignDetailController'
            }).
            when('/campaigns/edit/:campaignId', {
                templateUrl: '/build/assets/js/partials/admin/campaigns/edit.html',
                controller: 'CampaignEditController'
            }).
            otherwise({
                redirectTo: '/stats'
            });
    }]);