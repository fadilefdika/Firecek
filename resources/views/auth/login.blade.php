<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMS - APAR Management System</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-ams: #E11D48; 
            --primary-hover: #BE123C;
            --bg-body: #f1f5f9;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            margin: 0;
            padding: 15px; /* Menghindari card menempel di layar kecil */
        }

        .login-container {
            width: 100%;
            /* Diperkecil dari 480px ke 400px agar lebih padat */
            max-width: 400px; 
        }

        .ams-brand {
            /* Diperkecil dari 2.5rem ke 1.8rem */
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .ams-brand span {
            color: var(--primary-ams);
        }

        .login-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            overflow: hidden;
        }

        .login-header {
            /* Padding diperkecil */
            padding: 20px 24px 0;
            text-align: left;
        }

        .login-header h5 {
            font-weight: 700;
            color: #0f172a;
            /* Diperkecil dari 1.25rem ke 1.1rem */
            font-size: 1.1rem;
            margin-bottom: 2px;
        }

        .card-body {
            /* Padding diperkecil dari 32px ke 20px */
            padding: 16px 24px 24px;
        }

        .form-label {
            /* Ukuran font label lebih kecil */
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            display: block;
        }

        .input-group-custom {
            /* Margin antar input diperkecil */
            margin-bottom: 16px;
        }

        .form-control {
            width: 100%;
            box-sizing: border-box;
            border-radius: 6px;
            /* Padding input lebih ramping */
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            /* Font diperkecil ke 0.9rem */
            font-size: 0.9rem;
            transition: all 0.2s;
            color: #1e293b;
        }

        .form-control:focus {
            border-color: var(--primary-ams);
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
            outline: none;
        }

        .btn-ams {
            background-color: var(--primary-ams);
            color: white;
            border: none;
            border-radius: 6px;
            /* Padding tombol lebih pendek */
            padding: 11px;
            font-weight: 600;
            font-size: 0.9rem;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 4px;
        }

        .btn-ams:hover {
            background-color: var(--primary-hover);
        }

        .alert-modern {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #991b1b;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 0.8rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-text {
            text-align: center;
            margin-top: 16px;
            /* Font footer lebih kecil */
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .ams-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            padding: 4px 10px;
            border-radius: 4px;
            margin-top: 16px;
            font-weight: 500;
            font-size: 0.7rem;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        /* Responsivitas Mobile */
        @media (max-width: 480px) {
            .login-container {
                max-width: 100%;
            }
            .login-header, .card-body {
                padding-left: 16px;
                padding-right: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="mb-3 text-center">
            <h1 class="ams-brand">AMS<span>.</span></h1>
            <p style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500; margin-top: -4px;">
                APAR Management System
            </p>
        </div>
        
        <div class="card login-card">
            <div class="login-header">
                <h5>Welcome Back</h5>
                <p style="font-size: 0.8rem; color: var(--text-muted);">
                    Please login with your credentials.
                </p>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert-modern">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="encrypted_username" id="encrypted_username">
                    <input type="hidden" name="encrypted_password" id="encrypted_password">
                
                    <div class="input-group-custom">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" required placeholder="Enter Username">
                    </div>

                    <div class="input-group-custom">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" required placeholder="Enter Password">
                    </div>
                
                    <button type="submit" class="btn-ams">
                        <span>Sign In</span>
                        <i class="bi bi-arrow-right-short"></i>
                    </button>
                </form>

                <div class="text-center">
                    <div class="ams-badge">
                        <i class="bi bi-shield-lock-fill"></i>
                        EHS Standard Compliance
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-text">
            © {{ date('Y') }} PT Astra Visteon Indonesia<br>
            {{-- <span style="font-weight: 500;">EHSight v2.4 - Restricted Environment</span> --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsencrypt@3.0.0-rc.1/bin/jsencrypt.min.js"></script>
    <script>
        document.getElementById('login-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = this.querySelector('.btn-ams');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Signing In...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            const publicKey = `{!! str_replace(["\n", "\r"], ["\\n", ""], $publicKey) !!}`; 

            const encrypt = new JSEncrypt();
            encrypt.setPublicKey(publicKey);

            const encryptedUsername = encrypt.encrypt(username);
            const encryptedPassword = encrypt.encrypt(password);

            if (!encryptedUsername || !encryptedPassword) {
                alert('Connection encryption failed.');
                location.reload();
                return;
            }

            document.getElementById('encrypted_username').value = encryptedUsername;
            document.getElementById('encrypted_password').value = encryptedPassword;

            this.submit();
        });
    </script>

</body>
</html>