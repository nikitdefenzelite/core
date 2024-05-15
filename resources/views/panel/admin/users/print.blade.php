    @extends('layouts.empty')
    @section('title', 'User')
    @section('content')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="table-responsive">
                            @include('panel.admin.users.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
