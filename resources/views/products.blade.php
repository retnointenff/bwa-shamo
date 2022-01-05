<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="container bg-white p-3">
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="btn btn-primary" onclick="$('#formProduct').modal('show');">Add Product</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 pt-3">
                <table class="table table-bordered data-table" id="product-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $p)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $p->category_name }}</td>
                            <td>{{ $p->product_name }}</td>
                            <td>{{ $p->price }}</td>
                            <td>
                                <form action="{{ route('products.destroy', $p->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{route('products.show', $p->id)}}">Edit</a>

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="formProduct">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="product_categories_id">Category</label>
                            <select name="product_categories_id" id="product_categories_id" class="form-control" required>
                                <option selected disabled>Choose Category</option>
                                @foreach ($category as $c)
                                <option value="{{ $c->id }}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="3" placeholder="Enter decription product" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter product tags">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price" class="form-control" placeholder="Enter product price" required>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(() => {
            $('#product-table').DataTable({
                "search": true
            });
        });
    </script>
    @endpush
</x-app-layout>