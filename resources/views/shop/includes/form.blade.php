<link rel="stylesheet" href="{{ asset('css/uploadPhoto.css') }}">
<script src="{{asset('js/uploadPhoto.js')}}"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div style="position: static" class="card">
                <div class="card-header">{{ __('Upload inventory') }}</div>
                <div class="description">
                    <div class="row mb-3">
                        <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Product title') }} <b class="text-danger">*</b></label>
                        <div class="col-md-8">
                            <input id="title" type="text" maxlength="80" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>
                            <br>
                            <span id="titleChars">80</span> Character(s) Remaining
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Product description') }} <b class="text-danger">*</b></label>
                        <div class="col-md-8">
                            <textarea class="form-control form-control-lg" id="description" name="description" rows="5" maxlength="400" placeholder="Product description">@isset($edit){{ old('description',$product->description)}}@endisset</textarea>
                            <br>
                            <span id="descriptionChars">400</span> Character(s) Remaining
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Product price') }} <b class="text-danger">*</b></label>
                        <div class="col-md-8">
                            <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" autocomplete="price" autofocus>

                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="product" class="col-md-4 col-form-label text-md-end">{{ __('Product category') }} <b class="text-danger">*</b></label>
                        <div class="col-md-8">

                            <select required id="product" name="product" class="form-control"
                                    onchange="showElements('brand','size')">

                                <option disabled selected
                                        value="@isset($edit){{ old('brand',$product->product)}}@endisset"
                                >
                                    @isset($create)Select product @endisset
                                    @isset($edit){{ old('product',$product->product)}}@endisset
                                </option>

                                @foreach(App\Constants\GlobalConstants::LIST_PRODUCTS as $product)
                                    <option value="{{$product}}">{{$product}}</option>
                                @endforeach
                            </select>

                            @error('product')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label
                            @isset($create) style="display: none" @endisset
                        for="brand" class="col-md-4 col-form-label text-md-end" id="brand1">{{ __('Product brand') }}
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-8">

                            <select required @isset($create) style="display: none" @endisset class="form-control" name="brand" id="brand">
                                <option disabled selected
                                        value="@isset($edit){{ old('brand',$product->brand)}}@endisset"
                                >
                                    @isset($create)Select brand @endisset
                                    @isset($edit){{ old('brand',$product->brand)}}@endisset
                                </option>
                                @foreach(App\Constants\GlobalConstants::LIST_BRANDS as $brand)
                                    <option value="{{$brand}}">{{$brand}}</option>
                                @endforeach
                            </select>

                            @error('product')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label
                            @isset($create) style="display: none" @endisset
                        for="size" class="col-md-4 col-form-label text-md-end" id="size1">{{ __('Product size') }}
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-8">

                            <select required @isset($create) style="display: none" @endisset class="form-control" name="size" id="size">
                                <option selected disabled
                                        value="@isset($edit){{ old('size',$product->size)}}@endisset"
                                >
                                    @isset($create)Select size @endisset
                                    @isset($edit){{ old('size',$product->size)}}@endisset
                                </option>
                                @foreach(App\Constants\GlobalConstants::LIST_SIZES as $size)
                                    <option value="{{$size}}">{{$size}}</option>
                                @endforeach


                            </select>

                            @error('product')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="image" class="col-md-4 col-form-label text-md-end">
                        {{ __('Title photo') }}
                        <b class="text-danger">*</b>
                    </label>
                    <div class="col-md-8">
                        <div class="file-upload">
                            <div class="file-upload-placeholder">
                                <input id="image" name="image" class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
                                <div class="drag-text">
                                    <h3>Drag and drop photo or press here</h3>
                                </div>
                            </div>

                            <div class="file-upload-preview">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="file-upload-remove">
                                    <button type="button" onclick="removeUpload()" class="text-center btn btn-danger">Remove photo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center p-2">
                    <button class="btn btn-primary"> Create announcement</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        var descriptionMaxLength = 400;
        $('#description').keyup(function() {
            var textlen = descriptionMaxLength - $(this).val().length;
            $('#descriptionChars').text(textlen);
        });
        var titleMaxLength = 80;
        $('#title').keyup(function() {
            var textlen = titleMaxLength - $(this).val().length;
            $('#titleChars').text(textlen);
        });

        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            },
        );

        $(".shop").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 80,
                    regex: /^[^\s]+(\s+[^\s]+)*$/
                },
                description: {
                    required: true,
                    maxlength: 400,
                    regex: /^[^\s]+(\s+[^\s]+)*$/
                },
                city: {
                    required: true,
                    minlength: 3,
                    maxlength: 30,
                    regex: /^[^\s]+(\s+[^\s]+)*$/
                },
                price: {
                    required: true,
                    digits: true,
                    maxlength: 6
                },
                product: {
                    required: true
                },
                brand: {
                    required: true
                },
                size: {
                    required: true
                },
                cover: {
                    required:true
                }
            },
            messages: {
                title: {
                    required: "Please enter title field",
                    maxlength: "Title cannot be more than 80 characters",
                    regex: "No whitespaces allowed at the end or start of title field"
                },
                description: {
                    required: "Please enter description field",
                    maxlength: "Username cannot be more than 400 characters",
                    regex: "No whitespaces allowed at the end or start of description field"
                },
                city: {
                    required: "Please enter city field",
                    minlength: "Username must contain at least 3 characters",
                    maxlength: "Username cannot be more than 30 characters",
                    regex: "No whitespaces allowed at the end or start of city field"
                },
                price: {
                    required: "Please enter price field",
                    digits: "Price should be integer",
                    maxlength: "Price cannot be more than 6 digits"
                },
                product: {
                    required: "Please select product field"
                },
                brand: {
                    required: "Please select brand field"
                },
                size: {
                    required: "Please select size field"
                },
                cover: {
                    required: "Upload inventory photo"
                }
            }
        });
    });
</script>

