<div>
    <a href="{{ url()->previous() }}">
        <button class="btn-primary btn-sm">
            <i class="fa fa-angle-double-left"></i> Back
        </button>
    </a>




       @can('list_membershiphead')
        <a href="{{ route('admin.membershiphead.index') }}">
            <button class="btn-info btn-sm">All List <i class="fa fa-list"></i></button>
        </a>
        @endcan
 
        @can('create_membershiphead')
        <a href="{{ route('admin.membershiphead.create') }}">
            <button type="button" class="btn btn-block btn-success btn-sm" data-bs-toggle="modal" data-bs-target="">
                Add Membership Head <i class="fas fa-plus"></i>
            </button>
        @endcan
        </a>
   
</div>



