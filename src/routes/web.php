<?php

Route::group(['middleware' => ['web','admin.user']], function(){
    Route::get('/topup/export-language/download/{pkg}/{lang}/{name}', 'Topup\LangExport\Http\Controllers\ExportController@download')->name("topup.exportLang.download");
    Route::get('/topup/export-language', 'Topup\LangExport\Http\Controllers\ExportController@index')->name("topup.exportLang");
});
