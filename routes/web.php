<?php
    use App\Http\Controllers\Custom\EpaperController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

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
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/parse-csv-import', 'CategoriesController@parseCsvImport')->name('categories.parseCsvImport');
    Route::post('categories/process-csv-import', 'CategoriesController@processCsvImport')->name('categories.processCsvImport');
    Route::resource('categories', 'CategoriesController');

    // Tags
    Route::delete('tags/destroy', 'TagsController@massDestroy')->name('tags.massDestroy');
    Route::post('tags/parse-csv-import', 'TagsController@parseCsvImport')->name('tags.parseCsvImport');
    Route::post('tags/process-csv-import', 'TagsController@processCsvImport')->name('tags.processCsvImport');
    Route::resource('tags', 'TagsController');

    // Posts
    Route::delete('posts/destroy', 'PostsController@massDestroy')->name('posts.massDestroy');
    Route::post('posts/media', 'PostsController@storeMedia')->name('posts.storeMedia');
    Route::post('posts/ckmedia', 'PostsController@storeCKEditorImages')->name('posts.storeCKEditorImages');
    Route::post('posts/parse-csv-import', 'PostsController@parseCsvImport')->name('posts.parseCsvImport');
    Route::post('posts/process-csv-import', 'PostsController@processCsvImport')->name('posts.processCsvImport');
    Route::resource('posts', 'PostsController');

    // Gallery
    Route::delete('galleries/destroy', 'GalleryController@massDestroy')->name('galleries.massDestroy');
    Route::post('galleries/media', 'GalleryController@storeMedia')->name('galleries.storeMedia');
    Route::post('galleries/ckmedia', 'GalleryController@storeCKEditorImages')->name('galleries.storeCKEditorImages');
    Route::post('galleries/parse-csv-import', 'GalleryController@parseCsvImport')->name('galleries.parseCsvImport');
    Route::post('galleries/process-csv-import', 'GalleryController@processCsvImport')->name('galleries.processCsvImport');
    Route::resource('galleries', 'GalleryController');

    // Comments
    Route::delete('comments/destroy', 'CommentsController@massDestroy')->name('comments.massDestroy');
    Route::post('comments/parse-csv-import', 'CommentsController@parseCsvImport')->name('comments.parseCsvImport');
    Route::post('comments/process-csv-import', 'CommentsController@processCsvImport')->name('comments.processCsvImport');
    Route::resource('comments', 'CommentsController');

    // Header Logo
    Route::delete('header-logos/destroy', 'HeaderLogoController@massDestroy')->name('header-logos.massDestroy');
    Route::post('header-logos/media', 'HeaderLogoController@storeMedia')->name('header-logos.storeMedia');
    Route::post('header-logos/ckmedia', 'HeaderLogoController@storeCKEditorImages')->name('header-logos.storeCKEditorImages');
    Route::post('header-logos/parse-csv-import', 'HeaderLogoController@parseCsvImport')->name('header-logos.parseCsvImport');
    Route::post('header-logos/process-csv-import', 'HeaderLogoController@processCsvImport')->name('header-logos.processCsvImport');
    Route::resource('header-logos', 'HeaderLogoController');

    // Footer Logo
    Route::delete('footer-logos/destroy', 'FooterLogoController@massDestroy')->name('footer-logos.massDestroy');
    Route::post('footer-logos/media', 'FooterLogoController@storeMedia')->name('footer-logos.storeMedia');
    Route::post('footer-logos/ckmedia', 'FooterLogoController@storeCKEditorImages')->name('footer-logos.storeCKEditorImages');
    Route::post('footer-logos/parse-csv-import', 'FooterLogoController@parseCsvImport')->name('footer-logos.parseCsvImport');
    Route::post('footer-logos/process-csv-import', 'FooterLogoController@processCsvImport')->name('footer-logos.processCsvImport');
    Route::resource('footer-logos', 'FooterLogoController');

    // Contact Detail
    Route::delete('contact-details/destroy', 'ContactDetailController@massDestroy')->name('contact-details.massDestroy');
    Route::post('contact-details/parse-csv-import', 'ContactDetailController@parseCsvImport')->name('contact-details.parseCsvImport');
    Route::post('contact-details/process-csv-import', 'ContactDetailController@processCsvImport')->name('contact-details.processCsvImport');
    Route::resource('contact-details', 'ContactDetailController');

    // Contact Us
    Route::delete('contact-uss/destroy', 'ContactUsController@massDestroy')->name('contact-uss.massDestroy');
    Route::post('contact-uss/media', 'ContactUsController@storeMedia')->name('contact-uss.storeMedia');
    Route::post('contact-uss/ckmedia', 'ContactUsController@storeCKEditorImages')->name('contact-uss.storeCKEditorImages');
    Route::post('contact-uss/parse-csv-import', 'ContactUsController@parseCsvImport')->name('contact-uss.parseCsvImport');
    Route::post('contact-uss/process-csv-import', 'ContactUsController@processCsvImport')->name('contact-uss.processCsvImport');
    Route::resource('contact-uss', 'ContactUsController');

    // Newsletter
    Route::delete('newsletters/destroy', 'NewsletterController@massDestroy')->name('newsletters.massDestroy');
    Route::post('newsletters/parse-csv-import', 'NewsletterController@parseCsvImport')->name('newsletters.parseCsvImport');
    Route::post('newsletters/process-csv-import', 'NewsletterController@processCsvImport')->name('newsletters.processCsvImport');
    Route::resource('newsletters', 'NewsletterController');

    // Seo
    Route::delete('seos/destroy', 'SeoController@massDestroy')->name('seos.massDestroy');
    Route::post('seos/media', 'SeoController@storeMedia')->name('seos.storeMedia');
    Route::post('seos/ckmedia', 'SeoController@storeCKEditorImages')->name('seos.storeCKEditorImages');
    Route::post('seos/parse-csv-import', 'SeoController@parseCsvImport')->name('seos.parseCsvImport');
    Route::post('seos/process-csv-import', 'SeoController@processCsvImport')->name('seos.processCsvImport');
    Route::resource('seos', 'SeoController');

    // Epaper
    Route::delete('epapers/destroy', 'EpaperController@massDestroy')->name('epapers.massDestroy');
    Route::post('epapers/media', 'EpaperController@storeMedia')->name('epapers.storeMedia');
    Route::post('epapers/ckmedia', 'EpaperController@storeCKEditorImages')->name('epapers.storeCKEditorImages');
    Route::post('epapers/parse-csv-import', 'EpaperController@parseCsvImport')->name('epapers.parseCsvImport');
    Route::post('epapers/process-csv-import', 'EpaperController@processCsvImport')->name('epapers.processCsvImport');
    Route::resource('epapers', 'EpaperController');

    // Ads
    Route::delete('ads/destroy', 'AdsController@massDestroy')->name('ads.massDestroy');
    Route::post('ads/media', 'AdsController@storeMedia')->name('ads.storeMedia');
    Route::post('ads/ckmedia', 'AdsController@storeCKEditorImages')->name('ads.storeCKEditorImages');
    Route::post('ads/parse-csv-import', 'AdsController@parseCsvImport')->name('ads.parseCsvImport');
    Route::post('ads/process-csv-import', 'AdsController@processCsvImport')->name('ads.processCsvImport');
    Route::resource('ads', 'AdsController');

    // Create Event
    Route::delete('create-events/destroy', 'CreateEventController@massDestroy')->name('create-events.massDestroy');
    Route::post('create-events/media', 'CreateEventController@storeMedia')->name('create-events.storeMedia');
    Route::post('create-events/ckmedia', 'CreateEventController@storeCKEditorImages')->name('create-events.storeCKEditorImages');
    Route::post('create-events/parse-csv-import', 'CreateEventController@parseCsvImport')->name('create-events.parseCsvImport');
    Route::post('create-events/process-csv-import', 'CreateEventController@processCsvImport')->name('create-events.processCsvImport');
    Route::resource('create-events', 'CreateEventController');

    // Venue
    Route::delete('venues/destroy', 'VenueController@massDestroy')->name('venues.massDestroy');
    Route::post('venues/parse-csv-import', 'VenueController@parseCsvImport')->name('venues.parseCsvImport');
    Route::post('venues/process-csv-import', 'VenueController@processCsvImport')->name('venues.processCsvImport');
    Route::resource('venues', 'VenueController');

    // Seat Management
    Route::delete('seat-managements/destroy', 'SeatManagementController@massDestroy')->name('seat-managements.massDestroy');
    Route::post('seat-managements/parse-csv-import', 'SeatManagementController@parseCsvImport')->name('seat-managements.parseCsvImport');
    Route::post('seat-managements/process-csv-import', 'SeatManagementController@processCsvImport')->name('seat-managements.processCsvImport');
    Route::resource('seat-managements', 'SeatManagementController');

    // Bookin Seat
    Route::delete('bookin-seats/destroy', 'BookinSeatController@massDestroy')->name('bookin-seats.massDestroy');
    Route::post('bookin-seats/parse-csv-import', 'BookinSeatController@parseCsvImport')->name('bookin-seats.parseCsvImport');
    Route::post('bookin-seats/process-csv-import', 'BookinSeatController@processCsvImport')->name('bookin-seats.processCsvImport');
    Route::resource('bookin-seats', 'BookinSeatController');

    // Crousel
    Route::delete('crousels/destroy', 'CrouselController@massDestroy')->name('crousels.massDestroy');
    Route::post('crousels/media', 'CrouselController@storeMedia')->name('crousels.storeMedia');
    Route::post('crousels/ckmedia', 'CrouselController@storeCKEditorImages')->name('crousels.storeCKEditorImages');
    Route::post('crousels/parse-csv-import', 'CrouselController@parseCsvImport')->name('crousels.parseCsvImport');
    Route::post('crousels/process-csv-import', 'CrouselController@processCsvImport')->name('crousels.processCsvImport');
    Route::resource('crousels', 'CrouselController');

    // Breaking News
    Route::delete('breaking-newss/destroy', 'BreakingNewsController@massDestroy')->name('breaking-newss.massDestroy');
    Route::post('breaking-newss/parse-csv-import', 'BreakingNewsController@parseCsvImport')->name('breaking-newss.parseCsvImport');
    Route::post('breaking-newss/process-csv-import', 'BreakingNewsController@processCsvImport')->name('breaking-newss.processCsvImport');
    Route::resource('breaking-newss', 'BreakingNewsController');
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


// Custom Routes
Route::get('/',[App\Http\Controllers\Custom\IndexController::class,'index']);

Route::get('/post/{slug}',[App\Http\Controllers\Custom\PostController::class,'postDetails'])->name('post.details');
Route::get('/category/{slug}', [App\Http\Controllers\Custom\PostController::class, 'index'])
        ->name('category.posts');

Route::post('/newsletter/subscribe', [App\Http\Controllers\Custom\NewsLetterController::class, 'subscribe'])
    ->name('newsletter.subscribe');


Route::get('/epaper', [App\Http\Controllers\Custom\EpaperController::class, 'index'])->name('epaper.index');
Route::get('/epaper/{epaper}', [App\Http\Controllers\Custom\EpaperController::class, 'show'])->name('custom.epaper-detail');
Route::get('/pdf-view/{media}', function ($media) {
    $file = \Spatie\MediaLibrary\MediaCollections\Models\Media::findOrFail($media);
    $path = storage_path("app/public/{$file->id}/{$file->file_name}");

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Cross-Origin-Resource-Policy' => 'cross-origin',
    ]);
})->name('pdf.view');


Route::get('/gallery', [App\Http\Controllers\Custom\GalleryController::class, 'index'])->name('custom.gallery');
