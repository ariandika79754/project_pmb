<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Konfirmasi Registrasi</title>
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light py-5">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card shadow-sm">
          <div class="card-body text-center">
            <h4 class="mb-3 text-success">Registrasi Berhasil!</h4>
            <p class="mb-3">Berikut adalah akun Anda yang berhasil dibuat:</p>
            <table class="table table-bordered">
              <tr>
                <th>Username</th>
                <td><?= esc($email) ?></td>
              </tr>
              <tr>
                <th>Password</th>
                <td><?= esc($password) ?></td>
              </tr>
            </table>
            <p class="text-muted">Gunakan username dan password ini untuk login ke sistem.</p>
            <a href="<?= base_url('login') ?>" class="btn btn-primary mt-3">Login Sekarang</a>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
