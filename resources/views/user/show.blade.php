<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing Crud</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <div class="container mt-5">
        <table class="table border">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $getDataUser->name }}</td>
                    <td>{{ $getDataUser->email }}</td>
                    <td>
                        <a href="/user/edit/{{ $getDataUser->uuid }}" class="badge bg-primary">
                            <i class="fas fa-edit text-white"></i>
                        </a>

                        <button type="button" class="badge bg-danger" data-bs-toggle="modal"
                            data-bs-target="#exampleModal{{ $getDataUser->uuid }}">
                            <i class="fas fa-trash text-white"></i>
                        </button>

                        <div class="modal fade" id="exampleModal{{ $getDataUser->uuid }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            Hapus
                                            User?</h1>
                                    </div>

                                    <div class="modal-body">
                                        Apakah anda yakin untuk menghapus user ini? data
                                        akan
                                        terhapus permanen!
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>

                                        <form action="/user/delete/{{ $getDataUser->uuid }}" method="POST"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf

                                            <button type="submit" class="btn btn-primary">
                                                Ya Hapus!
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            </tbody>

        </table>
    </div>

</body>

</html>
