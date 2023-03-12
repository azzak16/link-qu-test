<!DOCTYPE html>
<html lang="en">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>

    <div class="wrapper m-2">
        <section class="content-header">
            <div class="container">
                <div class="row">

                    <div class="col-md-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Link Qu</h3>
                            </div>


                            <form>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="personal_data">Personal Data</label>
                                        <input type="text" class="form-control" id="personal_data"
                                            placeholder="Input your personal data" aria-describedby="dataHelpBlock">
                                        <small id="dataHelpBlock" class="form-text text-muted">
                                            Format : NAME[space]AGE[space]CITY
                                        </small>
                                        <div class="invalid-feedback" id="personal_feedback"></div>
                                    </div>

                                    <div class="float-right form-group">
                                        <a href="#" id="submit" class="btn btn-primary">Submit</a>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="table-personal">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Age</th>
                                                    <th>city</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->age }}</td>
                                                        <td>{{ $item->city }}</td>
                                                    </tr>
                                                @empty
                                                    <h3 id="info" class="text-center">Data Personal is empty</h3>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </section>
    </div>






    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').on('click', function () {

            var url = "{{ route('personal.store') }}";
            var personal_data = $('#personal_data').val();

            if(personal_data == null || personal_data == ''){
                $('#personal_data').addClass('is-invalid');
                $('#personal_feedback').html('Personal cannot be null, please fill in the appropriate format');
                $('#personal_feedback').css('display','block');
                return;
            }

            $.ajax({
                url : url,
                method: 'POST',
                data: {
                    personal_data:personal_data
                },
                dataType: 'json',
                success : function(result){

                    alert(result.message);

                    var rowCount = $('#table-personal > tbody > tr').length + 1;

                    var html = `<tr>
                                    <td>${rowCount}</td>
                                    <td>${result.data.name}</td>
                                    <td>${result.data.age}</td>
                                    <td>${result.data.city}</td>
                                </tr>`;

                    $('#table-personal > tbody:last-child').append(html);

                    if (rowCount == 1) {
                        $("#info").empty();
                    }

                    $('#personal_data').val(null);
                    $('#personal_data').removeClass('is-invalid');
                    $('#personal_feedback').css('display','none');

                },
                error: function(response) {
                    var response = response.responseJSON;

                    alert(response.message);

                    $('#personal_data').addClass('is-invalid');
                    $('#personal_feedback').html(response.message);
                    $('#personal_feedback').css('display','block');
                }
            });


        });

    </script>
</body>
</html>
