<div class='form-group clearfix'>
    <div class="col-sm-12">
        {{ Form::label($name,$title) }}
        {{ Form::textarea($name, $value, array_merge(['class' => 'form-control', 'id'=>$id, 'placeholder'=>'...', 'rows'=>'auto', 'cols'=>'auto'], (array) $attributes)) }}
    </div>
</div>
<script>
    $(document).ready(function () {
        CKEDITOR.replace('{{$id}}', {
            height: '{{$height}}',
            filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',
        });
    });
</script>