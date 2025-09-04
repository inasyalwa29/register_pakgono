<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Akun</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border-radius: 12px;
        }
        .btn-login {
            transition: all 0.3s ease;
        }
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .spinner-border {
            width: 20px;
            height: 20px;
            border-width: 2px;
        }
    </style>
</head>
<body>

<div class="container" style="margin-top: 80px">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h4 class="text-center mb-3">LOGIN AKUN</h4>
                <hr>

                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Masukkan Email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Masukkan Password" required>
                </div>

                <button class="btn btn-success w-100 btn-login">
                    <span class="login-text">LOGIN</span>
                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                </button>

                <div class="text-center mt-3">
                    Belum punya akun? <a href="{{ route('register.index') }}">Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    $(".btn-login").click(function(e) {
        e.preventDefault();

        let email    = $("#email").val().trim();
        let password = $("#password").val().trim();
        let token    = $("meta[name='csrf-token']").attr("content");

        if (email === "" || password === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Email dan Password wajib diisi!'
            });
            return;
        }

        // Disable button & show loading
        $(".btn-login").attr("disabled", true);
        $(".login-text").text("Memproses...");
        $(".spinner-border").removeClass("d-none");

        $.ajax({
            url: "{{ route('login.check') }}",
            type: "POST",
            dataType: "json",
            data: {
                email: email,
                password: password,
                _token: token
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Mengalihkan ke dashboard...',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(function() {
                        window.location.href = response.redirect || "{{ route('dashboard.index') }}";
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal!',
                        text: response.message || 'Email atau password salah!'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Terjadi kesalahan pada server!'
                });
                console.error(xhr.responseText);
            },
            complete: function() {
                // Enable kembali button setelah selesai
                $(".btn-login").attr("disabled", false);
                $(".login-text").text("LOGIN");
                $(".spinner-border").addClass("d-none");
            }
        });
    });

});
</script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
