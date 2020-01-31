app.config(['$routeProvider', function($routeProvider) {

    $routeProvider.
    when('/testimonials', {
        template: '<testimonials></testimonials>',
        title: 'Testimonials',
    });
}]);

app.component('testimonials', {
    templateUrl: testimonials_template_url,
    controller: function($http, $location, HelperService, $scope, $routeParams, $rootScope, $location) {
        $scope.loading = true;
        var self = this;
        self.hasPermission = HelperService.hasPermission;
        $http({
            url: laravel_routes['getTestimonials'],
            method: 'GET',
        }).then(function(response) {
            self.testimonials = response.data.testimonials;
            $rootScope.loading = false;
        });
        $rootScope.loading = false;
    }
});
