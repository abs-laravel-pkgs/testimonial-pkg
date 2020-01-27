@if(config('custom.PKG_DEV'))
    <?php $testimonial_pkg_prefix = '/packages/abs/testimonial-pkg/src';?>
@else
    <?php $testimonial_pkg_prefix = '';?>
@endif

<script type="text/javascript">
    var testimonial_list_template_url = "{{asset($testimonial_pkg_prefix.'/public/themes/'.$theme.'/testimonial-pkg/testimonial/list.html')}}";
    var testimonial_form_template_url = "{{asset($testimonial_pkg_prefix.'/public/themes/'.$theme.'/testimonial-pkg/testimonial/form.html')}}";
</script>
<script type="text/javascript" src="{{asset($testimonial_pkg_prefix.'/public/themes/'.$theme.'/testimonial-pkg/testimonial/controller.js')}}"></script>
