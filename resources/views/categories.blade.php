<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="container bg-white p-3">
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="btn btn-primary" onclick="$('#formAddCategory').modal('show');">Add Category</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 pt-3">
                <table class="table table-bordered data-table" id="category-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category Name</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $p)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $p->name }}</td>
                            <td>
                                <form action="#" method="POST">

                                    <a class="btn btn-primary" href="#">Edit</a>

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

    <div class="modal" tabindex="-1" role="dialog" id="formAddCategory">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('categories.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter category name" name="name">
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
            $('#category-table').DataTable({
                "search": true
            });
        });
    </script>
    @endpush
</x-app-layout>