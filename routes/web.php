<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::post('permissions/parse-csv-import', 'PermissionsController@parseCsvImport')->name('permissions.parseCsvImport');
    Route::post('permissions/process-csv-import', 'PermissionsController@processCsvImport')->name('permissions.processCsvImport');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::post('roles/parse-csv-import', 'RolesController@parseCsvImport')->name('roles.parseCsvImport');
    Route::post('roles/process-csv-import', 'RolesController@processCsvImport')->name('roles.processCsvImport');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Contacts
    Route::delete('contacts/destroy', 'ContactsController@massDestroy')->name('contacts.massDestroy');
    Route::post('contacts/parse-csv-import', 'ContactsController@parseCsvImport')->name('contacts.parseCsvImport');
    Route::post('contacts/process-csv-import', 'ContactsController@processCsvImport')->name('contacts.processCsvImport');
    Route::resource('contacts', 'ContactsController');

    // Wallet
    Route::delete('wallets/destroy', 'WalletController@massDestroy')->name('wallets.massDestroy');
    Route::post('wallets/parse-csv-import', 'WalletController@parseCsvImport')->name('wallets.parseCsvImport');
    Route::post('wallets/process-csv-import', 'WalletController@processCsvImport')->name('wallets.processCsvImport');
    Route::resource('wallets', 'WalletController');

    // Transactions
    Route::delete('transactions/destroy', 'TransactionsController@massDestroy')->name('transactions.massDestroy');
    Route::post('transactions/parse-csv-import', 'TransactionsController@parseCsvImport')->name('transactions.parseCsvImport');
    Route::post('transactions/process-csv-import', 'TransactionsController@processCsvImport')->name('transactions.processCsvImport');
    Route::resource('transactions', 'TransactionsController');

    // Sms Template
    Route::delete('sms-templates/destroy', 'SmsTemplateController@massDestroy')->name('sms-templates.massDestroy');
    Route::post('sms-templates/media', 'SmsTemplateController@storeMedia')->name('sms-templates.storeMedia');
    Route::post('sms-templates/ckmedia', 'SmsTemplateController@storeCKEditorImages')->name('sms-templates.storeCKEditorImages');
    Route::post('sms-templates/parse-csv-import', 'SmsTemplateController@parseCsvImport')->name('sms-templates.parseCsvImport');
    Route::post('sms-templates/process-csv-import', 'SmsTemplateController@processCsvImport')->name('sms-templates.processCsvImport');
    Route::resource('sms-templates', 'SmsTemplateController');

    // Email Template
    Route::delete('email-templates/destroy', 'EmailTemplateController@massDestroy')->name('email-templates.massDestroy');
    Route::post('email-templates/media', 'EmailTemplateController@storeMedia')->name('email-templates.storeMedia');
    Route::post('email-templates/ckmedia', 'EmailTemplateController@storeCKEditorImages')->name('email-templates.storeCKEditorImages');
    Route::post('email-templates/parse-csv-import', 'EmailTemplateController@parseCsvImport')->name('email-templates.parseCsvImport');
    Route::post('email-templates/process-csv-import', 'EmailTemplateController@processCsvImport')->name('email-templates.processCsvImport');
    Route::resource('email-templates', 'EmailTemplateController');

    // Whats App Template
    Route::delete('whats-app-templates/destroy', 'WhatsAppTemplateController@massDestroy')->name('whats-app-templates.massDestroy');
    Route::post('whats-app-templates/media', 'WhatsAppTemplateController@storeMedia')->name('whats-app-templates.storeMedia');
    Route::post('whats-app-templates/ckmedia', 'WhatsAppTemplateController@storeCKEditorImages')->name('whats-app-templates.storeCKEditorImages');
    Route::post('whats-app-templates/parse-csv-import', 'WhatsAppTemplateController@parseCsvImport')->name('whats-app-templates.parseCsvImport');
    Route::post('whats-app-templates/process-csv-import', 'WhatsAppTemplateController@processCsvImport')->name('whats-app-templates.processCsvImport');
    Route::resource('whats-app-templates', 'WhatsAppTemplateController');

    // Sms
    Route::delete('smss/destroy', 'SmsController@massDestroy')->name('smss.massDestroy');
    Route::post('smss/parse-csv-import', 'SmsController@parseCsvImport')->name('smss.parseCsvImport');
    Route::post('smss/process-csv-import', 'SmsController@processCsvImport')->name('smss.processCsvImport');
    Route::resource('smss', 'SmsController');

    // Email
    Route::delete('emails/destroy', 'EmailController@massDestroy')->name('emails.massDestroy');
    Route::post('emails/parse-csv-import', 'EmailController@parseCsvImport')->name('emails.parseCsvImport');
    Route::post('emails/process-csv-import', 'EmailController@processCsvImport')->name('emails.processCsvImport');
    Route::resource('emails', 'EmailController');

    // Whats App
    Route::delete('whats-apps/destroy', 'WhatsAppController@massDestroy')->name('whats-apps.massDestroy');
    Route::post('whats-apps/parse-csv-import', 'WhatsAppController@parseCsvImport')->name('whats-apps.parseCsvImport');
    Route::post('whats-apps/process-csv-import', 'WhatsAppController@processCsvImport')->name('whats-apps.processCsvImport');
    Route::resource('whats-apps', 'WhatsAppController');

    // Sms Setup
    Route::delete('sms-setups/destroy', 'SmsSetupController@massDestroy')->name('sms-setups.massDestroy');
    Route::post('sms-setups/parse-csv-import', 'SmsSetupController@parseCsvImport')->name('sms-setups.parseCsvImport');
    Route::post('sms-setups/process-csv-import', 'SmsSetupController@processCsvImport')->name('sms-setups.processCsvImport');
    Route::resource('sms-setups', 'SmsSetupController');

    // Email Setup
    Route::delete('email-setups/destroy', 'EmailSetupController@massDestroy')->name('email-setups.massDestroy');
    Route::post('email-setups/parse-csv-import', 'EmailSetupController@parseCsvImport')->name('email-setups.parseCsvImport');
    Route::post('email-setups/process-csv-import', 'EmailSetupController@processCsvImport')->name('email-setups.processCsvImport');
    Route::resource('email-setups', 'EmailSetupController');

    // Whats App Setup
    Route::delete('whats-app-setups/destroy', 'WhatsAppSetupController@massDestroy')->name('whats-app-setups.massDestroy');
    Route::post('whats-app-setups/parse-csv-import', 'WhatsAppSetupController@parseCsvImport')->name('whats-app-setups.parseCsvImport');
    Route::post('whats-app-setups/process-csv-import', 'WhatsAppSetupController@processCsvImport')->name('whats-app-setups.processCsvImport');
    Route::resource('whats-app-setups', 'WhatsAppSetupController');

    // Organizer
    Route::delete('organizers/destroy', 'OrganizerController@massDestroy')->name('organizers.massDestroy');
    Route::post('organizers/media', 'OrganizerController@storeMedia')->name('organizers.storeMedia');
    Route::post('organizers/ckmedia', 'OrganizerController@storeCKEditorImages')->name('organizers.storeCKEditorImages');
    Route::post('organizers/parse-csv-import', 'OrganizerController@parseCsvImport')->name('organizers.parseCsvImport');
    Route::post('organizers/process-csv-import', 'OrganizerController@processCsvImport')->name('organizers.processCsvImport');
    Route::resource('organizers', 'OrganizerController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Route::get('/get-contacts-by-organizer/{id}', [App\Http\Controllers\Admin\EmailController::class, 'getContacts'])
    ->name('contacts.by.organizer');
