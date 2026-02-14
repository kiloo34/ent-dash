<?php

use App\Models\User;
use App\Services\Dashboard\DashboardResolverFactory;
use App\Services\Dashboard\SuperAdminResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('there are exactly 3 super admins', function () {
    $count = User::role('super-admin')->count();
    expect($count)->toBe(3);
});

test('super admin has all permissions', function () {
    $user = User::role('super-admin')->first();
    expect($user)->not->toBeNull();
    foreach (Permission::all() as $permission) {
        expect($user->hasPermissionTo($permission->name))->toBeTrue();
    }
});

test('edm admin does not have manage role permission', function () {
    $user = User::role('edm-admin')->first();
    expect($user)->not->toBeNull();
    expect($user->hasPermissionTo('manage-role'))->toBeFalse();
});

test('non role structural positions have no system access', function () {
    $user = User::whereHas('position', function ($q) {
        $q->whereIn('name', ['SEVP', 'VP', 'AVP']);
    })->first();
    expect($user)->not->toBeNull();
    expect($user->roles->count())->toBe(0);
});

test('factory returns correct resolver for super admin', function () {

    $user = \App\Models\User::role('super-admin')->first();

    $resolver = DashboardResolverFactory::make($user);

    expect($resolver)->toBeInstanceOf(SuperAdminResolver::class);
});

test('dashboard redirect works correctly', function () {

    $user = \App\Models\User::role('super-admin')->first();

    $response = $this->actingAs($user)
        ->get(route('dashboard'));

    $response->assertRedirect(route('superadmin.dashboard'));
});
