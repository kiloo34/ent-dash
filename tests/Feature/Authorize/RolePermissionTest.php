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

test('there is exactly 1 super admin', function () {
    $count = User::role(\App\Enums\RoleType::SUPER_ADMIN->value)->count();
    expect($count)->toBe(1);
});

test('super admin has all permissions', function () {
    $user = User::role(\App\Enums\RoleType::SUPER_ADMIN->value)->first();
    expect($user)->not->toBeNull();
    foreach (Permission::all() as $permission) {
        expect($user->hasPermissionTo($permission->name))->toBeTrue();
    }
});

test('admin does not have manage role permission', function () {
    $user = User::role(\App\Enums\RoleType::ADMIN->value)->first();
    expect($user)->not->toBeNull();
    expect($user->hasPermissionTo('manage-role'))->toBeFalse();
});

test('all structural positions have roles assigned', function () {
    $users = User::all();
    foreach ($users as $user) {
        expect($user->roles->count())->toBeGreaterThan(0);
    }
});

test('factory returns correct resolver for super admin', function () {
    $user = User::role(\App\Enums\RoleType::SUPER_ADMIN->value)->first();
    $resolver = DashboardResolverFactory::make($user);
    expect($resolver)->toBeInstanceOf(SuperAdminResolver::class);
});

test('dashboard redirect works correctly for super admin', function () {
    $user = User::role(\App\Enums\RoleType::SUPER_ADMIN->value)->first();
    $response = $this->actingAs($user)
        ->get(route('dashboard'));

    $response->assertRedirect(route('superadmin.dashboard'));
});
