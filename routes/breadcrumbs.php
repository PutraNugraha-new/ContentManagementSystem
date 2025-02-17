<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Dashboard > Profile
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Profile', url('/profile'));
});

// Dashboard > Posts
Breadcrumbs::for('posts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Posts', route('posts.index'));
});

// Dashboard > Posts > Create
Breadcrumbs::for('posts.create', function (BreadcrumbTrail $trail) {
    $trail->parent('posts.index');
    $trail->push('Create Posts', route('posts.create'));
});

// Dashboard > Posts > Edit
Breadcrumbs::for('posts.edit', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('posts.index');
    $trail->push('Edit Posts', route('posts.edit', $item));
});

// Dashboard > Posts > author
Breadcrumbs::for('posts.byAuthor', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('posts.index');
    $trail->push('Posts By Author', route('posts.byAuthor', $item));
});

// Dashboard > Posts > Category
Breadcrumbs::for('posts.byCategory', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('posts.index');
    $trail->push('Posts By Category', route('posts.byCategory', $item));
});


// Dashboard > Categories
Breadcrumbs::for('categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Categories', route('categories.index'));
});

// Dashboard > Categories > Create
Breadcrumbs::for('categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('categories.index');
    $trail->push('Create Category', route('categories.create'));
});

// Dashboard > Categories > Edit
Breadcrumbs::for('categories.edit', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('categories.index');
    $trail->push('Edit Category', route('categories.edit', $item));
});

// Dashboard > Tags
Breadcrumbs::for('tags.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Tags', route('tags.index'));
});

// Dashboard > Tags > Create
Breadcrumbs::for('tags.create', function (BreadcrumbTrail $trail) {
    $trail->parent('tags.index');
    $trail->push('Create Tag', route('tags.create'));
});

// Dashboard > Tags > Edit
Breadcrumbs::for('tags.edit', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('tags.index');
    $trail->push('Edit Tag', route('tags.edit', $item));
});

// Dashboard > Users
Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('users.index'));
});

// Dashboard > Users > Create
Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('Create User', route('users.create'));
});

// Dashboard > Users > Edit
Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('users.index');
    $trail->push('Edit User', route('users.edit', $item));
});

// Dashboard > Settings
Breadcrumbs::for('settings.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Settings', route('settings.index'));
});

// Dashboard > Commnents
Breadcrumbs::for('comments.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Comments', route('comments.index'));
});
