<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Categories
    Route::apiResource('categories', 'CategoriesApiController');

    // Tags
    Route::apiResource('tags', 'TagsApiController');

    // Posts
    Route::post('posts/media', 'PostsApiController@storeMedia')->name('posts.storeMedia');
    Route::apiResource('posts', 'PostsApiController');

    // Gallery
    Route::post('galleries/media', 'GalleryApiController@storeMedia')->name('galleries.storeMedia');
    Route::apiResource('galleries', 'GalleryApiController');

    // Comments
    Route::apiResource('comments', 'CommentsApiController');

    // Header Logo
    Route::post('header-logos/media', 'HeaderLogoApiController@storeMedia')->name('header-logos.storeMedia');
    Route::apiResource('header-logos', 'HeaderLogoApiController');

    // Footer Logo
    Route::post('footer-logos/media', 'FooterLogoApiController@storeMedia')->name('footer-logos.storeMedia');
    Route::apiResource('footer-logos', 'FooterLogoApiController');

    // Contact Detail
    Route::apiResource('contact-details', 'ContactDetailApiController');

    // Contact Us
    Route::post('contact-uss/media', 'ContactUsApiController@storeMedia')->name('contact-uss.storeMedia');
    Route::apiResource('contact-uss', 'ContactUsApiController');

    // Newsletter
    Route::apiResource('newsletters', 'NewsletterApiController');

    // Seo
    Route::post('seos/media', 'SeoApiController@storeMedia')->name('seos.storeMedia');
    Route::apiResource('seos', 'SeoApiController');

    // Epaper
    Route::post('epapers/media', 'EpaperApiController@storeMedia')->name('epapers.storeMedia');
    Route::apiResource('epapers', 'EpaperApiController');

    // Ads
    Route::post('ads/media', 'AdsApiController@storeMedia')->name('ads.storeMedia');
    Route::apiResource('ads', 'AdsApiController');

    // Create Event
    Route::post('create-events/media', 'CreateEventApiController@storeMedia')->name('create-events.storeMedia');
    Route::apiResource('create-events', 'CreateEventApiController');

    // Venue
    Route::apiResource('venues', 'VenueApiController');

    // Seat Management
    Route::apiResource('seat-managements', 'SeatManagementApiController');

    // Bookin Seat
    Route::apiResource('bookin-seats', 'BookinSeatApiController');

    // Crousel
    Route::post('crousels/media', 'CrouselApiController@storeMedia')->name('crousels.storeMedia');
    Route::apiResource('crousels', 'CrouselApiController');

    // Breaking News
    Route::apiResource('breaking-newss', 'BreakingNewsApiController');
});
