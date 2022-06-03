<link rel="stylesheet" href="{{ asset('css/uploadPhoto.css') }}">
<script src="{{asset('js/uploadPhoto.js')}}"></script>
<script src="{{asset('js/announcementPhoto.js')}}"></script>

@csrf
<div class="container">
    <div class="row justify-content-center">
        @isset($edit)
            <div class="col-md-3" style="position: fixed;left: 11%">
                <div class="card-header">
                    {{ __('Photo gallery') }}
                </div>
                <div class="col-md-4">
                    <div class="images p-3">
                        <div class="text-center p-4">
                            @if($announcement->cover == 'null')
                                <img id="main-image" src="{{asset('covers/default.jpg')}}" height="250" width="250" />
                            @else
                                <img id="main-image" src="{{asset('covers/'.$announcement->cover)}}" height="250" width="250" />
                            @endif

                        </div>
                        <div style="display: flex">
                            @if($announcement->cover == 'null')
                                <img onclick="change_image(this)" src="{{asset('covers/default.jpg')}}" height="70" width="70" />
                            @else
                                <img onclick="change_image(this)" src="{{asset('covers/'.$announcement->cover)}}" height="70" width="70" />
                            @endif
                            @foreach($images as $image)
                                <img onclick="change_image(this)" src="{{asset('announcement_images/'.$image->image)}}" height="70" width="70">
                            @endforeach
                        </div>

                        <div style="display: flex;">


                            <button disabled id="cover" formmethod="post" formaction="{{route('announcement.deleteCover',$announcement->id)}}" style="width: 70px" class="btn text-white btn-sm">Remove</button>

                            @foreach($images as $image)
                                <button class="deleteRecord btn text-danger btn-sm" data-id="{{ $image->id }}" >Remove</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endisset

        <div class="col-md-8">
            <div style="position: static; margin-left: 28%" class="card">
                @include('layouts.success')
                <div class="card-header">
                    @isset($edit){{ __('Edit announcement') }}@endisset
                    @isset($create){{ __('Create announcement') }}@endisset
                </div>
                <div class="description">
                    <div class="row mb-3">
                        <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Announcement title') }} <b class="text-danger">*</b></label>
                        <div class="col-md-8">
                            <input
                                id="title"
                                type="text"
                                maxlength="80"
                                class="form-control @error('title') is-invalid @enderror"
                                name="title"
                                value="{{ old('title') }}@isset($edit){{$announcement->title}}@endisset"
                                autocomplete="title"
                                autofocus
                            >
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
                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="5"
                                maxlength="400"
                                placeholder="Product description">@isset($edit){{ old('description',$announcement->description)}}@endisset</textarea>
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
                        <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City') }} <b class="text-danger">*</b></label>
                        <div class="col-md-8">
                            <input
                                id="city"
                                type="text"
                                maxlength="80"
                                class="form-control @error('title') is-invalid @enderror"
                                name="city"
                                value="{{ old('city') }}@isset($edit){{$announcement->city}}@endisset"
                                autocomplete="title"
                                autofocus
                            >
                            @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price') }} <b class="text-danger">*</b></label>
                        <div class="col-md-8">
                            <input
                                id="price"
                                type="text"
                                maxlength="80"
                                class="form-control @error('price') is-invalid @enderror"
                                name="price"
                                value="{{ old('price') }}@isset($edit){{$announcement->price}}@endisset"
                                autocomplete="title"
                                autofocus
                            >
                            @error('city')
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
                                        value="@isset($edit){{ old('brand',$announcement->product)}}@endisset"
                                >
                                    @isset($create)Select product @endisset
                                    @isset($edit){{ old('product',$announcement->product)}}@endisset
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
                                        value="@isset($edit){{ old('brand',$announcement->brand)}}@endisset"
                                >
                                    @isset($create)Select brand @endisset
                                    @isset($edit){{ old('brand',$announcement->brand)}}@endisset
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
                            for="size" class="col-md-4 col-form-label text-md-end" id="size1">
                            {{ __('Product size') }}
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-8">

                            <select required @isset($create) style="display: none" @endisset class="form-control" name="size" id="size">
                                <option selected disabled
                                        value="@isset($edit){{ old('size',$announcement->size)}}@endisset"
                                >
                                    @isset($create)Select size @endisset
                                    @isset($edit){{ old('size',$announcement->size)}}@endisset
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


                    <div class="row mb-3">
                        <label for="cover" class="col-md-4 col-form-label text-md-end">{{ __('Title photo') }}&nbsp;&nbsp;&nbsp;</label>
                        <div class="col-md-8">
                            <div class="file-upload">
                                <div class="file-upload-placeholder ">
                                    <input id="covers" name="cover" class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
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


                    @isset($edit)
                        <button id="submit-all" style="position:fixed; left: 90%;top: 92%" class="justify-content-md-end btn-bg btn btn-primary"> Edit</button>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $( document ).ready(function() {
        $(".deleteRecord").click(function(){
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax(
                {
                    url: "/deleteimage/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                });
        });
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

        $(".announcement").validate({
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
                }
            }
        });
    });

</script>

