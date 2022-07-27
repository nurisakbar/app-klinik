<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preview QR Code for whatsapp</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body class="bg-info">
  <div class="container">
    <div class="card my-5 shadow-lg">
      <div class="card-title">
        <div class="row">
          <div class="col-md-3">
            <a href="{{ url('setting') }}" class="btn btn-sm btn-primary">Kembali</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center">
            <p>Klik link dibawah untuk mendapatkan QR Code whatsapp</p>
            <div class="text-center">
              <a href="{{ $link }}" class="btn btn-success">Get link</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>