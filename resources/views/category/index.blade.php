@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Category</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Category Table</h3>
                </div>
                <!-- /.card-header -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Add Category</button>

                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>                  
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->type }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <button data-toggle="modal" data-target="#modal-edit" data-item="{{ json_encode($category) }}" type="button" class="btn btn-success btn-xs modal-edit"><i class="fas fa-pencil-alt"></i></button>
                                <button data-toggle="modal" data-target="#modal-delete" data-item="{{ $category->id }}" type="button" class="btn btn-danger btn-xs modal-delete"><i class="fas fa-trash-alt"></i></button>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->

                <!-- /.box-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        @if($categories->onFirstPage())
                        <li class="disabled page-item"><a class="page-link" href="#">«</a></li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ $categories->previousPageUrl() }}">«</a></li>
                        @endif
                        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                            @if ($page == $categories->currentPage())
                            <li class="active page-item"><a class="page-link" href="#">{{ $page }}</a></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                        @if($categories->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $categories->nextPageUrl() }}">»</a></li>
                        @else
                        <li class="disabled page-item"><a class="page-link" href="#">»</a></li>
                        @endif
                    </ul>
                </div>
              </div>
        </div>
    </div>

    <!-- modal add -->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" action="{{ url()->current() }}" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{old('name')}}" required>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>Type</label>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="type" value="Pemasukan" checked="">
                                  <label class="form-check-label">Pemasukan</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="type" value="Pengeluaran">
                                  <label class="form-check-label">Pengeluaran</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="Description" value="{{old('description')}}" required>  
                            {{ csrf_field() }}              
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- modal edit -->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-edit" role="form" action="{{ url()->current() }}/edit" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control modal-input-name" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>Type</label>
                                <div class="form-check">
                                  <input id="check-pem" class="form-check-input" type="radio" name="type" value="Pemasukan">
                                  <label class="form-check-label">Pemasukan</label>
                                </div>
                                <div class="form-check">
                                  <input id="check-peng" class="form-check-input" type="radio" name="type" value="Pengeluaran">
                                  <label class="form-check-label">Pengeluaran</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control modal-input-description" name="description" placeholder="Description" required>
                            @csrf            
                            @method('PUT')
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete category?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <form id="form-delete" role="form" action="#" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-light">Yes</button>
                </form>
            </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


@stop
@section('js')
    <script>
        $('.modal-edit').click(function(){
            var data = JSON.parse($(this).attr('data-item'));
            $('.modal-input-name').val(data.name);
            $('.modal-input-description').val(data.description);
            if (data.type === 'Pemasukan') {
                $("#check-pem").prop("checked", true);
            } else if(data.type === 'Pengeluaran') {
                $("#check-peng").prop("checked", true);
            }
            $('#form-edit').attr('action', '/category/'+data.id);
        });
        $('.modal-delete').click(function(){
            var data = $(this).attr('data-item');
            $('#form-delete').attr('action', '/category/'+data);
        });
    </script>
@stop