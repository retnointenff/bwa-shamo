<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="container bg-white p-3">
        <div class="row">
            @foreach ($product as $product)
            <div class="col-sm-12 pt-3">
                <div class="form-group">
                    <label for="price">Product Image</label>
                    <div class="row">
                        <div class="col-sm-12 d-flex flex-start">
                            <form action="{{route('products/imageStore')}}" method="POST" id="formImage" enctype="multipart/form-data" style="width: fit-content;">
                                @csrf
                                <img src="https://via.placeholder.com/200/?text=Add New Image" alt="" class="img-thumbnail" width="200" height="200" id="img-placeholder">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="file" name="image" id="image" class="form-control mt-2" onchange="readURL(this)">
                            </form>
                            @for ($i = 0; $i < 3; $i++) <img src="{{$gallery[$i]->url}}" alt="" class="img-thumbnail" style="height: 200px; width: 200px; margin-left: 1em;"> @endfor
                                @if (count($gallery) >3)
                                <img src="https://via.placeholder.com/200/?text={{(count($gallery)-3).' more'}}" alt="" class="img-thumbnail" style="height: 200px; width: 200px; margin-left: 1em;">
                                @endif
                        </div>
                    </div>
                </div>
                <hr class="mb-2">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="product_category_id">Category</label>
                        <select class="form-control" id="product_category_id" required>
                            <option selected disabled></option>
                            @foreach ($category as $c)
                            <option value="{{$c->id}}" {{($c->id==$product->product_categories_id) ? 'selected':''}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" id="name" value="{{$product->name}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{$product->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="tags">Product Tags</label>
                        <input type="text" name="tags" id="tags" value="{{$product->tags}}" class="form-control" required value="{{$product->tags}}">
                    </div>
                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <input type="text" name="price" id="price" value="{{$product->price}}" class="form-control" required value="{{$product->price}}">
                    </div>
                    <div class="row float-right">
                        <div class="col">
                            <a class="btn btn-danger" href="{{route('products.index')}}">Cancel</a>
                            <input type="submit" value="Edit" class="btn btn-primary">
                        </div>
                    </div>
                </form>




            </div>
            @endforeach
        </div>
    </div>
    @push('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-placeholder').attr('src', e.target.result).width(200).height(200);
                };

                reader.readAsDataURL(input.files[0]);

            }
            $("form#formImage").submit();
        }
    </script>
    @endpush
</x-app-layout>