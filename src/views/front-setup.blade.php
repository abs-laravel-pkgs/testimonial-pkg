@if(config('testimonial-pkg.DEV'))
    <?php $testimonial_pkg_prefix = '/packages/abs/testimonial-pkg/src';?>
@else
    <?php $testimonial_pkg_prefix = '';?>
@endif

<script type="text/javascript">
	app.config(['$routeProvider', function($routeProvider) {

	    $routeProvider.
	    when('/testimonials', {
	        template: '<testimonials></testimonials>',
	        title: 'Testimonials',
	    });
	}]);


    var testimonials_template_url = "{{asset($testimonial_pkg_prefix.'/public/themes/'.$theme.'/testimonial-pkg/testimonial/testimonials.html')}}";
    var testimonialFormAndListTemplate = "{{asset($testimonial_pkg_prefix.'/public/themes/'.$theme.'/testimonial-pkg/testimonial/testimonial-form-and-list.html')}}";

</script>
<script type="text/javascript" src="{{asset($testimonial_pkg_prefix.'/public/themes/'.$theme.'/testimonial-pkg/testimonial/controller.js')}}"></script>
