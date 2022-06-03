@csrf
<div class="form-group">
    <div class="card-header">
        <label for="card-element">
            Payment information
        </label>
    </div>
    <div class="card-body">
        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>
        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
        <input type="hidden" name="plan" value="" />
    </div>
</div>
<div class="card-footer">
    <button
        id="card-button"
        class="btn btn-dark"
        type="submit"
        data-secret="{{ $intent }}"
    > Pay </button>
    @isset($shop)
        @if($total<250)
            <p class="float-end">Total cart sum: <b>{{$total+3}} €</b></p>
        @else
            <p class="float-end">Total cart sum: <b>{{$total}} €</b></p>
        @endif
    @endisset
</div>
