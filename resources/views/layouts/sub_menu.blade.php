@if(isset(request()->route()->action['prefix']))
    @switch(request()->route()->action['prefix'])
        @case('/teams')
            @php
                $menuOpt = [
                    'Criar Times' => route('teams.create'),
                    'Listar times' => route('teams')
                ];
            @endphp
            @break
    @endswitch

    @if(isset($menuOpt))
        @foreach($menuOpt as $key => $value)
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ $value }}" class="nav-link"> {{ $key }} </a>
            </li>
        @endforeach
    @endif
@endif