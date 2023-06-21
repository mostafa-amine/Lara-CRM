@can('create', App\Models\User::class)

<div {{ $attributes->merge([
    'class' => 'd-flex justify-content-between',
    ]) }}>
    <x-buttons.anchor :href="route('users.create')" content="Create user" color="success" />
</div>
@endcan

<form action="{{ route('users.index') }}" method="get">
    <div class="d-flex">
        <div class="col-12">
            <input class="form-control " name="filter[name]" placeholder="search by name, email" type="text"
                value="{{ request()->input('filter.name') }}">
        </div>
    </div>
    <div class="d-flex mt-2">
        @foreach ($roles as $role)
        <div class="form-check ms-2 me-2">
            <input class="form-check-input" type="checkbox" name="filter[role][]" value="{{ $role->name }}"
                id="{{ $role->name }}" @if(in_array($role->name, request()->input('filter.role', []))) checked @endif>
            <label class="custom-control-label" for="{{ $role->name }}">{{ $role->name }}</label>
        </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-success btn-sm mt-2">Apply</button>
    <button type="button" class="btn btn-danger btn-sm mt-2" id="bulk_actions">Bulk Actions</button>
    <span class="check_count"></span>
</form>
<div class="d-flex">
    <button class="btn btn-success btn-sm mt-2 me-2 d-none" id="export">Export Selected Data</button>
    <button class="btn btn-info btn-sm mt-2 d-none" id="import">Import Data</button>
</div>

<div class="d-none importForm">
    <input type="file" id="file" name="file" class="form-control mb-3">
    <button class="btn btn-light" type="submit" id="submit">Upload File</button>
</div>
