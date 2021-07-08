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
        <h4 class="d-block">Upload & Parse App Strings</h4>

        <form action="{{ route('topup.exportLang.parseJS') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="jsFile" id="jsFile"/>
            </div>
            <button type="submit" class="btn btn-default">Upload & Parse</button>
        </form>

        <hr/>
        <h4 class="d-block">Click The File Name Bellow To Download Excel Of BO Strings</h4>
        @foreach($languageFiles as $index => $languageFile)
            <ul class="list-group">
                <li class="list-group-item active">{{ $index }}</li>
                @foreach($languageFile as $file)
                    <li class="list-group-item">[{{ $file['package'] }}] <a
                            href="{{ route('topup.exportLang.download', [$file['package'], $index, $file['name']]) }}">{{ $file['file'] }}</a>
                    </li>
                @endforeach
            </ul>
        @endforeach

    </div>
@endsection
