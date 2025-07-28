<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firecek - GA Department Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .firecek-brand {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: #d32f2f;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .firecek-brand span {
            color: #f44336;
        }
        .login-card {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-top: 4px solid #d32f2f;
        }
        .login-header {
            background-color: #f5f5f5;
            border-bottom: 1px solid #e0e0e0;
            padding: 1rem;
            border-radius: 8px 8px 0 0;
        }
        .btn-firecek {
            background-color: #d32f2f;
            border-color: #d32f2f;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-firecek:hover {
            background-color: #b71c1c;
            border-color: #b71c1c;
            transform: translateY(-1px);
        }
        .ehs-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 0.7rem;
            color: #757575;
        }
        .form-control:focus {
            border-color: #d32f2f;
            box-shadow: 0 0 0 0.25rem rgba(211, 47, 47, 0.25);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-3 mt-3">
                    <h1 class="firecek-brand">FIRE<span>CEK</span></h1>
                    <p class="text-muted">General Affair Department</p>
                </div>
                
                <div class="card login-card">
                    <div class="login-header text-center">
                        <h5 class="mb-0">SAFETY FIRST</h5>
                        <small class="text-muted">Environment, Health & Safety Compliance</small>
                    </div>
                    <div class="card-body">
                        <form id="login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="encrypted_username" id="encrypted_username">
                            <input type="hidden" name="encrypted_password" id="encrypted_password">
                        
                            <div class="mb-3">
                                <label for="username" class="form-label fw-medium">Username</label>
                                <input type="text" id="username" class="form-control py-2" required placeholder="Masukkan username Anda">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <input type="password" id="password" class="form-control py-2" required placeholder="Masukkan password Anda">
                            </div>
                        
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        
                            <button type="submit" class="btn btn-firecek btn-lg w-100 py-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i>LOGIN
                            </button>
                        </form>
                        
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-muted">© {{ date('Y') }} Firecek GA Department - EHS Compliance</small>
                </div>
                <div class="ehs-badge">
                    <small>EHS Standard Compliance</small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jsencrypt@3.0.0-rc.1/bin/jsencrypt.min.js"></script>
<script>
    document.getElementById('login-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        const publicKey = `{!! str_replace(["\n", "\r"], ["\\n", ""], $publicKey) !!}`; // Embed dari controller

        const encrypt = new JSEncrypt();
        encrypt.setPublicKey(publicKey);

        const encryptedUsername = encrypt.encrypt(username);
        const encryptedPassword = encrypt.encrypt(password);

        if (!encryptedUsername || !encryptedPassword) {
            alert('Enkripsi gagal. Silakan coba lagi.');
            return;
        }

        document.getElementById('encrypted_username').value = encryptedUsername;
        document.getElementById('encrypted_password').value = encryptedPassword;

        this.submit();
    });
</script>

</body>
</html>