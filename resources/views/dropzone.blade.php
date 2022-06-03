
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">

<form id="dropzoneForm" class="dropzone" action="{{ route('dropzone.upload') }}">
    @csrf
    @isset($edit)
        <input hidden name="announcement_id" value="{{$announcement->id}}">
    @endisset
    @isset($create)
        <input hidden name="announcement_id" value="{{$announcement_id}}">
    @endisset
</form>


<script type="text/javascript">
    var numImgs = $('img').length

    Dropzone.options.dropzoneForm = {
        autoProcessQueue : false,
        addRemoveLinks: true,
        acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",
        @isset($create)
            maxFiles: 2,
        @endisset
        @isset($edit)
            maxFiles: 5-numImgs,
        @endisset
        parallelUploads: 2,


        init:function() {
            var submitButton = document.querySelector("#submit-all");
            myDropzone = this;

            submitButton.addEventListener('click', function () {
                myDropzone.processQueue();
            });
        }}
</script>
