<?php

Route::group(['middleware' => ['web','admin.user']], function(){
    Route::get('/topup/export-language/download/{pkg}/{lang}/{name}', 'Topup\LangExport\Http\Controllers\ExportController@download')->name("topup.exportLang.download");
    Route::get('/topup/export-language', 'Topup\LangExport\Http\Controllers\ExportController@index')->name("topup.exportLang");
    Route::post('/topup/export-language', 'Topup\LangExport\Http\Controllers\ExportController@parseJS')->name("topup.exportLang.parseJS");
    Route::put('/topup/export-language', 'Topup\LangExport\Http\Controllers\ExportController@downloadJSStrings')->name("topup.exportLang.dlJS");
});
