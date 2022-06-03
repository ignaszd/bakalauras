@if(session()->has('message'))
    <div id="successMessage" style="height: 25px" class="alert alert-success md-3 pt-0 text-center">
        <p>{{ session()->get('message') }}</p>
    </div>
@endif
