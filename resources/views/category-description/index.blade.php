<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kategori Keperluan | BukuTamu</title>

    <link rel="stylesheet" href="{{asset('/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/datatables/1.10.24/css/dataTables.bootstrap4.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('/js/jquery-3.5.1.slim.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('/datatables/1.10.24/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/datatables/1.10.24/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('/fontawesome/all.min.js')}}"></script>
</head>
<body>
        @include("navbar")

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-3 text-center">Daftar Tamu UPT TIK UNS</h1>
                <div class="text-center">
                    <a class="btn btn-lg btn-primary my-3" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-user-plus"></i> Tambah Kategori Keperluan</a>
                </div>

                {{-- MODAL TAMBAH DATA --}}
                <div class="modal fade" id="modal-tambah" aria-labelledby="tambahModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahModalLabel">Form Tambah Kategori Keperluan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="/category-description">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama">Nama Kategori</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Masukkan nama kategori" name="name" value="{{old('name')}}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                            {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                
                                    {{-- BUTTON --}}
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- MODAL TAMBAH DATA END --}}

                {{-- INFO SESSION --}}
                @if (session('tambah'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('tambah') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif (session('update'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('update') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif (session('hapus'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('hapus') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                {{-- INFO SESSION END --}}
                
                <table class="table display table-light" id="guest-datatable" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a id="edit" class="btn btn-warning edit" data-toggle="modal" data-target="#modal-edit"
                                data-id = "{{ $category->id }}"
                                data-name = "{{$category->name}}"
                                ><i class="fas fa-edit"></i></a>

                                <form action="/category-description/{{$category->id}}" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin?')">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger tombol-hapus"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- MODAL EDIT --}}
                <div class="modal fade" id="modal-edit" aria-labelledby="tambahModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahModalLabel">Form Ubah Kategori Keperluan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="/category-description/" id="editForm">
                                    @method('put')
                                    @csrf
                                    <div class="form-group">
                                        <label for="ename">Nama Kategori</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="ename" placeholder="Masukkan nama kategori" name="ename" value="{{old('ename')}}">
                                        @error('ename')
                                            <div class="invalid-feedback">
                                            {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                
                                    {{-- BUTTON --}}
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Ubah Data</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT MODAL EDIT --}}
    <script>
        $(document).ready(function(){
            $(document).on('click', '#edit', function(){
        
                var id = $(this).data('id');
                var name = $(this).data('name');
                
                $('#ename').val(name);
                
                console.log($(this).data())
                // Tambahkan ID di action
                $('#editForm').attr('action', '/category-description/'+id);
            })
        });
    </script>
</body>
</html>