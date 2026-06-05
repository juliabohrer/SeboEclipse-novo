<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro · Eclipse Sebo</title>
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
            padding: 2rem 1rem;
        }

        .card {
            background: #1a1a24;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 520px;
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: #c9a84c;
            text-transform: uppercase;
        }

        .logo p {
            font-size: 0.8rem;
            opacity: 0.5;
            margin-top: 0.25rem;
        }

        .section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            opacity: 0.4;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .full { grid-column: 1 / -1; }

        .form-group { display: flex; flex-direction: column; gap: 0.35rem; }

        label {
            font-size: 0.78rem;
            opacity: 0.7;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        input {
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 6px;
            color: #e0e0e0;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus { border-color: #c9a84c; }

        .field-error {
            color: #e05555;
            font-size: 0.78rem;
        }

        .alert-error {
            background: rgba(224,85,85,0.1);
            border: 1px solid rgba(224,85,85,0.3);
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

        .btn {
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
            margin-top: 1.5rem;
        }

        .btn:hover { opacity: 0.85; }

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
    </style>
</head>
<body>

    <div class="card">

        <div class="logo">
            <h1>Eclipse Sebo</h1>
            <p>Crie sua conta de cliente</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <strong>Corrija os erros abaixo:</strong>
                <ul style="margin-top: 0.5rem; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('cadastro.store') }}">
            @csrf

            <p class="section-title">Dados Pessoais</p>

            <div class="form-grid">

                <div class="form-group full">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome"
                        value="{{ old('nome') }}"
                        placeholder="Ex.: João da Silva">
                    @error('nome') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento"
                        value="{{ old('data_nascimento') }}">
                    @error('data_nascimento') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf"
                        value="{{ old('cpf') }}"
                        placeholder="000.000.000-00">
                    @error('cpf') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco"
                        value="{{ old('endereco') }}"
                        placeholder="Ex.: Rua das Flores, 123 — Centro">
                    @error('endereco') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone"
                        value="{{ old('telefone') }}"
                        placeholder="(00) 00000-0000">
                    @error('telefone') <span class="field-error">{{ $message }}</span> @enderror
                </div>

            </div>

            <p class="section-title">Acesso</p>

            <div class="form-grid">

                <div class="form-group full">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="exemplo@email.com">
                    @error('email') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha"
                        placeholder="Mínimo 6 caracteres">
                    @error('senha') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="senha_confirmation">Confirmar Senha</label>
                    <input type="password" id="senha_confirmation" name="senha_confirmation"
                        placeholder="Repita a senha">
                </div>

            </div>

            <button type="submit" class="btn">Criar Conta</button>

        </form>

        <p class="footer-link">
            Já tem conta?
            <a href="{{ route('login') }}">Faça login</a>
        </p>

    </div>

</body>
</html>