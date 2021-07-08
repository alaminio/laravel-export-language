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
        <h4 class="d-block">App strings</h4>

        <form action="{{ route('topup.exportLang.dlJS') }}" method="post" id="downloadJSForm">
            @method('PUT')
            @csrf
            <input id="langName" type="hidden" name="lang" value="">
            <input id="langString" type="hidden" name="strings" value="">
        </form>

        <ul class="list-group" id="buttonList">

        </ul>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script defer>
        var AppString = {!! $jsContent !!};
        $(function () {

            var listHTML = '';
            for (lang in AppString) {
                listHTML += '<li class="list-group-item"><a data-lang="' + lang + '" href="" class="downloadJSStrings">' + lang + '</a></li>';
            }
            $('#buttonList').html(listHTML);

            registerDownloadEvent();
        });

        function registerDownloadEvent() {
            $('.downloadJSStrings').on('click', function (e) {
                e.preventDefault();
                var lang = $(this).data('lang');

                $('#langString').val(JSON.stringify(AppString[lang]));
                $('#langName').val(lang);

                $('#downloadJSForm').submit();
            })
        }
    </script>
@endsection
