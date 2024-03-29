@props(['organizations'])

@if ($organizations->isEmpty())
<div class="pt-3 pb-2">
    <h4 class="text-muted">No organizations found.</h4>
</div>
@else
<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Website</th>
                <th>Address</th>
                <th>Projects count</th>
                <th>Actions</th>
            </tr>
        </thead>

        @if(auth()->user()->role === 'admin')
        section diyalt admin
        @endif
        
        @if(auth()->user()->role === 'directeur')
        section diyalt directeur
        @endif
        ...

        <tbody>
            @foreach ($organizations as $organization)
            <tr>
                <td>{{ $organization->name }}</td>
                <td><a href="{{ $organization->website }}">Link</a></td>
                <td>{{ $organization->address }}</td>
                <td>
                    <span class="badge rounded-pill bg-success" style="font-size: 12px">
                        {{ $organization->projects_count }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        @can('view', $organization)
                        <x-buttons.anchor :href="route('organizations.show', $organization)" content="Show" size="small"
                            color="primary" />
                        @endcan
                        @can('update', $organization)
                        <x-buttons.anchor :href="route('organizations.edit', $organization)" content="Edit" size="small"
                            color="warning" />
                        @endcan
                        @can('delete', $organization)
                        <x-buttons.form :action="route('organizations.destroy', $organization)" content="Delete"
                            size="small" color="danger" />
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $organizations->links() }}
@endif
