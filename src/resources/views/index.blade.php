@extends('voyager::master')

@section('content')
    <style>
        .topup-export-lang-container {
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
        }
    </style>

    <div class="topup-export-lang-container">
        <h4 class="d-block">Click the file name bellow to download Excel</h4>

        @foreach($languageFiles as $index => $languageFile)
            <ul class="list-group">
                <li class="list-group-item active">{{ $index }}</li>
            @foreach($languageFile as $file)
                    <li class="list-group-item">[{{ $file['package'] }}] <a href="{{ route('topup.exportLang.download', [$file['package'], $index, $file['name']]) }}">{{ $file['file'] }}</a></li>
                @endforeach
            </ul>
        @endforeach

    </div>
@endsection
