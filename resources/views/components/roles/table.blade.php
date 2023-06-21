@props(['roles'])
<div class="table-responsive">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
                <td>{{ $role->title }}</td>
                <td>
                    <div class="d-flex gap-1">
                        @can('view', $role)
                        <x-buttons.anchor :href="route('roles.show', $role)" content="Show" size="small"
                            color="primary" />
                        @endcan
                        @can('update', $role)
                        <x-buttons.anchor :href="route('roles.edit', $role)" content="Edit" size="small"
                            color="warning" />
                        @endcan
                        @can('delete', $role)
                        <a href="{{ route('roles.destroy', $role) }}" class="btn btn-danger btn-sm"
                            data-confirm-delete="true">Delete</a>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $roles->links() }}