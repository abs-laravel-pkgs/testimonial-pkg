app.component('testimonials', {
    templateUrl: testimonials_template_url,
    controller: function($http, $location, HelperService, $scope, $routeParams, $rootScope, $location) {
        var self = this;
        self.hasPermission = HelperService.hasPermission;
    }
});

app.component('testimonialFormAndList', {
    templateUrl: testimonialFormAndListTemplate,
    bindings: {
        data: '<',
    },
    controller: function($http, HelperService, $scope, $rootScope, $routeParams, $location) {
        $scope.loading = true;
        var self = this;
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
