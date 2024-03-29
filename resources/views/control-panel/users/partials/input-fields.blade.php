<div class="d-flex col-12 justify-content-between">
    <div class="mb-3 col-6 me-2">
        <x-forms.text name="name" label="Name" :value="optional($user)->name" />
    </div>
    <div class="mb-3 col-6">
        <x-forms.email name="email" label="Email" :value="optional($user)->email" />
    </div>
</div>
<div class="d-flex col-12 justify-content-between">
    <div class="mb-3 col-6 me-2">
        <x-forms.text name="phone" label="Phone number" :value="optional($user)->phone" />
    </div>
    <div class="mb-3 col-6">
        <x-forms.text name="address" label="Address" :value="optional($user)->address" />
    </div>
</div>

@can('updateRole', $user)
<div class="mb-3">
    <x-forms.select name="role_title" label="Role" :options="$roles" :selected="$user->roles->first()->title" />
</div>
@endcan
<div class="d-flex col-12 justify-content-center">
    <div class="mb-3 col-6 me-2">
        <x-forms.password name="password" label="Password" />
    </div>
    <div class="mb-3 col-6">
        <x-forms.password name="password_confirmation" label="Password confirmation" />
    </div>
</div>