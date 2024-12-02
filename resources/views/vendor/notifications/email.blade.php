<x-mail::message>
    {{-- Cabeçalho Personalizado --}}
    @if (!empty($greeting))
        # {{ $greeting }}
    @else
        @if ($level === 'error')
            # Ops!
        @else
            # Olá!
        @endif
    @endif

    {{-- Nome da Empresa no Cabeçalho --}}
    # **Psycotecher**

    {{-- Linhas de Introdução --}}
    <p>{{ __('passwords.intro_line') }}</p>

    {{-- Botão de Ação --}}
    @isset($actionText)
            <?php
            $color = match ($level) {
                'success', 'error' => $level,
                default => 'primary',
            };
        ?>
            <x-mail::button :url="$actionUrl">
                {{ __('passwords.action_text') }}
            </x-mail::button>

    @endisset

    {{-- Linhas Finais --}}
    <p>{{ __('passwords.outro_line') }}</p>

    {{-- Saudação Final --}}
    @if (!empty($salutation))
        {{ $salutation }}
    @else
        Atenciosamente,<br>
        Psycotech
    @endif

    {{-- Nota de Rodapé --}}
    @isset($actionText)
        <x-slot:subcopy>
            Se você estiver com problemas para clicar no botão "{{ __('passwords.action_text') }}", copie e cole o URL
            abaixo em seu navegador:
            <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
        </x-slot:subcopy>
    @endisset
</x-mail::message>