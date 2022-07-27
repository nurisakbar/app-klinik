<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">KLINIK NURDIN WAHID</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Disabled</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
           Tanggal : {{ date('d m Y') }}
          </form>
        </div>
      </nav>
      
    <div class="container-fluid" style="margin-top:30px;">
        <div class="row">
            <div class="col-md-6">
                <video width="95%" controls autoplay>
                    <source src="{{asset('antrian/video.mp4')}}" type="video/mp4">
                  Your browser does not support the video tag.
                  </video> 
            </div>
            <div class="col-md-6 text-center">
              <div class="row mx-n5">
                <div class="col px-5">
                  <div class="p-3 border bg-light">
                    <h6>ANTRIAN</h6>
                    <h2 class="text-center">001</h2>
                    <h6> KE POLI UMUM</h6>
                  </div>
                </div>
                <div class="col px-5">
                  <div class="p-3 border bg-light">
                    <h6>ANTRIAN</h6>
                    <h2 class="text-center">001</h2>
                    <h6> KE POLI UMUM</h6>
                  </div>
                </div>
              </div>

              <div class="row mx-n5" Style="margin-top:10px;">
                <div class="col px-5">
                  <div class="p-3 border bg-light">
                    <h6>ANTRIAN</h6>
                    <h2 class="text-center">001</h2>
                    <h6> KE POLI UMUM</h6>
                  </div>
                </div>
                <div class="col px-5">
                  <div class="p-3 border bg-light">
                    <h6>ANTRIAN</h6>
                    <h2 class="text-center">001</h2>
                    <h6> KE POLI UMUM</h6>
                  </div>
                </div>
              </div>

              <div class="row mx-n5" Style="margin-top:10px;">
                <div class="col px-5">
                  <div class="p-3 border bg-light">
                    <h6>ANTRIAN</h6>
                    <h2 class="text-center">001</h2>
                    <h6> KE POLI UMUM</h6>
                  </div>
                </div>
                <div class="col px-5">
                  <div class="p-3 border bg-light">
                    <h6>ANTRIAN</h6>
                    <h2 class="text-center">001</h2>
                    <h6> KE POLI UMUM</h6>
                  </div>
                </div>
              </div>
            </div>
        </div>
        </div>
    </div>




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
  </body>
</html>
