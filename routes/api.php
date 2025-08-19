<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Contacts
    Route::apiResource('contacts', 'ContactsApiController');

    // Wallet
    Route::apiResource('wallets', 'WalletApiController');

    // Transactions
    Route::apiResource('transactions', 'TransactionsApiController');

    // Sms Template
    Route::post('sms-templates/media', 'SmsTemplateApiController@storeMedia')->name('sms-templates.storeMedia');
    Route::apiResource('sms-templates', 'SmsTemplateApiController');

    // Email Template
    Route::post('email-templates/media', 'EmailTemplateApiController@storeMedia')->name('email-templates.storeMedia');
    Route::apiResource('email-templates', 'EmailTemplateApiController');

    // Whats App Template
    Route::post('whats-app-templates/media', 'WhatsAppTemplateApiController@storeMedia')->name('whats-app-templates.storeMedia');
    Route::apiResource('whats-app-templates', 'WhatsAppTemplateApiController');

    // Sms
    Route::apiResource('smss', 'SmsApiController');

    // Email
    Route::apiResource('emails', 'EmailApiController');

    // Whats App
    Route::apiResource('whats-apps', 'WhatsAppApiController');

    // Sms Setup
    Route::apiResource('sms-setups', 'SmsSetupApiController');

    // Email Setup
    Route::apiResource('email-setups', 'EmailSetupApiController');

    // Whats App Setup
    Route::apiResource('whats-app-setups', 'WhatsAppSetupApiController');

    // Organizer
    Route::post('organizers/media', 'OrganizerApiController@storeMedia')->name('organizers.storeMedia');
    Route::apiResource('organizers', 'OrganizerApiController');
});
