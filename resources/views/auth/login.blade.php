<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · Eclipse Sebo</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f0f13;
            font-family: 'Segoe UI', sans-serif;
            color: #e0e0e0;
        }

        .login-card {
            background: #1a1a24;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: #c9a84c;
            text-transform: uppercase;
        }

        .login-logo p {
            font-size: 0.8rem;
            opacity: 0.5;
            margin-top: 0.25rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.8rem;
            opacity: 0.7;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 6px;
            color: #e0e0e0;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus {
            border-color: #c9a84c;
        }

        .field-error {
            display: block;
            color: #e05555;
            font-size: 0.8rem;
            margin-top: 0.35rem;
        }

        .alert-error {
            background: rgba(224, 85, 85, 0.1);
            border: 1px solid rgba(224, 85, 85, 0.3);
            border-radius: 6px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            color: #e05555;
        }

        .alert-success {
            background: rgba(85,185,85,0.1);
            border: 1px solid rgba(85,185,85,0.3);
            border-radius: 6px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            color: #55b955;
        }

        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: #c9a84c;
            color: #0f0f13;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: opacity 0.2s;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            opacity: 0.85;
        }

        .footer-link {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.85rem;
            opacity: 0.6;
        }

        .footer-link a {
            color: #c9a84c;
            text-decoration: none;
        }

        .footer-link a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="login-card">

        <div class="login-logo">
            <h1>Eclipse Sebo</h1>
            <p>Faça login para continuar</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="seu@email.com"
                    autofocus
                >
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input
                    type="password"
                    id="senha"
                    name="senha"
                    placeholder="••••••••"
                >
            </div>

            <button type="submit" class="btn-login">
                Entrar
            </button>

        </form>

        <p class="footer-link">
            Não tem conta?
            <a href="{{ route('cadastro') }}">Cadastre-se</a>
        </p>

    </div>

</body>
</html>