<!-- js for validation -->
<script type="text/javascript">
$(".{{ $class }}").validate({
  rules: {
    {!! $rules !!}
  }
});
</script>