@props(['users'])
@if ($users->isEmpty())
<div>
    <h4 class="fs-6 text-center p-2">No users found.</h4>
</div>
@else

<div class="table-responsive">
    <table class="table main_table align-items-center mb-0 table2excel">
        <thead>
            <tr>
                <th class="font-weight-bolder">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="checkAll" id="checkAll">
                    </div>
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone number</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr id="{{ 'table_' . $user->id }}">
                <td class="text-xs text-secondary mb-0">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input table_check" name="{{ $user->id }}" id="{{ 'table_' . $user->id }}">
                    </div>
                </td>
                <td class="text-xs text-secondary mb-0">{{ $user->id }}</td>
                <td class="text-xs text-secondary mb-0">{{ $user->name }}</td>
                <td class="text-xs text-secondary mb-0">{{ $user->email }}</td>
                <td class="text-xs text-secondary mb-0">{{ $user->phone }}</td>
                <td class="text-xs text-secondary mb-0">{{ $user->address }}</td>
                <td class="align-middle  text-secondary text-center">
                    <span class="badge rounded-pill bg-success" style="font-size: 10px">
                        {{$user->roles->first()->title}}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        @can('view', $user)
                        <x-buttons.anchor style="font-size: 10px" :href="route('users.show', $user)" content="Show"
                            size="small" color="deafult" />
                        @endcan
                        @can('update', $user)
                        <x-buttons.anchor style="font-size: 10px" :href="route('users.edit', $user)" content="Edit"
                            size="small" color="warning" />
                        @endcan
                        @can('delete', $user)
                        <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm"
                            data-confirm-delete="true">Delete</a>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endif
