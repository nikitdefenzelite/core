<div class="card-body">
    <form class="row" action="{{ route('panel.admin.profile.update.password', $user->id) }}" method="POST">
        @csrf
        <input type="hidden" name="request_with" value="password">
        {{-- <div class="col-12">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="password">Current Password <span class="text-danger">*</span></label>
                    <input required type="password" class="form-control" name="current_password" placeholder="Current Password" id="current-password">
                </div>
            </div>
        </div> --}}
        <div class="col-12">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="password">New Password <span class="text-danger">*</span></label>
                    <input required type="password" class="form-control" name="password" placeholder="New Password"
                        id="password">
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
            <input required type="password" class="form-control" name="confirm_password" placeholder="Confirm Password"
                id="confirm-password">
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary" type="submit">Change {{ Str::limit($user->full_name, 20) }}
                Password</button>
        </div>
    </form>
</div>
