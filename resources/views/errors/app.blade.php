<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title : 'Erro' }} - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <style>
            /* Fallback CSS baseado na identidade visual do projeto */
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background: linear-gradient(135deg, #fff3e8 0%, #ffe3cf 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #334155;
                line-height: 1.6;
            }

            .error-container {
                background: white;
                border-radius: 16px;
                padding: 3rem;
                box-shadow: 0 10px 30px rgba(16, 24, 40, 0.1);
                text-align: center;
                max-width: 500px;
                width: 90%;
                margin: 2rem;
            }

            .error-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 2rem;
                background: #fff3e8;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .error-message {
                font-size: 1.25rem;
                font-weight: 500;
                color: #334155;
                margin-bottom: 1.5rem;
                line-height: 1.5;
            }

            .error-description {
                color: #64748b;
                margin-bottom: 2rem;
                font-size: 1rem;
            }

            .action-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.2s;
                font-size: 0.875rem;
                border: none;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-primary {
                background: #ff6a00;
                color: white;
            }

            .btn-primary:hover {
                background: #e95e00;
            }

            .btn-secondary {
                background: #f1f5f9;
                color: #334155;
                border: 1px solid #e2e8f0;
            }

            .btn-secondary:hover {
                background: #e2e8f0;
            }

            @media (max-width: 640px) {
                .error-container {
                    padding: 2rem;
                    margin: 1rem;
                }

                .action-buttons {
                    flex-direction: column;
                }

                .btn {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>
    @endif
</head>

<body>
    <div class="min-h-screen bg-gradient-to-br from-brand-50 to-brand-100 flex items-center justify-center p-4">
        <div class="bg-surface rounded-[--radius] shadow-lg p-8 max-w-md w-full text-center">
            <!-- Ícone de erro -->
            <div class="w-20 h-20 mx-auto mb-6 bg-brand-50 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>

            <!-- Mensagem de erro -->
            <h1 class="text-lg font-medium text-neutral-900 mb-4 leading-relaxed">
                {{ $message ?? 'Ocorreu um erro inesperado' }}
            </h1>

            <!-- Descrição adicional -->
            <p class="text-neutral-500 mb-2">
                Lamentamos pelo inconveniente. Nosso time foi notificado e está trabalhando para resolver este problema.
            </p>
            <p class="text-neutral-500 mb-8">
                Caso solicitado, informe o código de erro abaixo.
            </p>

            <!-- Botões de ação -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button onclick="window.history.back()"
                    class="inline-flex items-center justify-center px-6 py-3 bg-brand-500 text-white rounded-lg font-medium hover:bg-brand-600 transition-colors duration-200 hover:cursor-pointer">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar
                </button>

                <a href="{{ '/' }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-neutral-100 text-neutral-700 rounded-lg font-medium hover:bg-neutral-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Início
                </a>
            </div>

            <!-- Link de suporte adicional -->
            <div class="mt-8 pt-6 border-t border-neutral-200">
                <p class="text-sm text-neutral-400">
                    Precisa de ajuda?
                    <a href="mailto:suporte@example.com?subject=Suporte%20-%20Erro%20{{ $code ?? '' }}&body=Código%20do%20Erro:%20{{ $code ?? 'N/A' }}%0D%0AMensagem:%20{{ $message ?? 'N/A' }}%0D%0A"
                        class="text-brand-500 hover:text-brand-600 transition-colors">
                        Entre em contato
                    </a>
                </p>

                @isset($code)
                    <p class="text-sm text-neutral-700 leading-relaxed">
                        Código de erro: {{ $code }}
                    </p>
                @endisset
            </div>
        </div>
    </div>

    <!-- Script para melhorar a experiência de navegação -->
    <script>
        // Verifica se há histórico de navegação disponível
        if (window.history.length <= 1) {
            // Se não há histórico, esconde o botão voltar e ajusta o layout
            const backButton = document.querySelector('button[onclick="window.history.back()"]');
            if (backButton) {
                backButton.style.display = 'none';
            }
        }

        // Adiciona funcionalidade de teclado para melhor acessibilidade
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                window.history.back();
            }
        });
    </script>
</body>

</html>