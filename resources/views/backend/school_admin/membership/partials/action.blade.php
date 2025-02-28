<div>
    <a href="{{ url()->previous() }}">
        <button class="btn-primary btn-sm">
            <i class="fa fa-angle-double-left"></i> Back
        </button>
    </a>
    
    @can('list_members')
    <a href="{{ route('admin.members.index') }}">
        <button class="btn-info btn-sm">All List <i class="fa fa-list"></i></button>
    </a>
    @endcan

    @can('create_members')
    <a href="{{ route('admin.members.create') }}">
        <button type="button" class="btn btn-success btn-sm">
            Add Member <i class="fas fa-plus"></i>
        </button>
    </a>
    @endcan
</div>