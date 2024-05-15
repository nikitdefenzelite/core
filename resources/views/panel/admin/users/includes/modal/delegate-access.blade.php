<!-- Modal -->
<style>
    #report_link-button {
        height: 40px;
    }
</style>
<div class="modal fade" id="DelegateAccessModel" tabindex="-1" aria-labelledby="DelegateAccessModelLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-custom">
                <h5 class="modal-title" id="DelegateAccessModelLabel">{{ __('admin/ui.Access_Step') }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="get">
                    <h5>
                        Accessing <strong><span class="delegateUserName"></span>'s Panel</strong>
                    </h5>
                    <div class="form-group">
                        <input type="hidden" value="" name="user_id" class="delegateUserId">
                        <label for="" class="">{{ __('admin/ui.sixDigit') }}<span
                                class="text-danger">*</span></label>
                        <input type="number" value="" class="form-control text-center" placeholder="Enter Access Code"
                               name="delegate_access" required>
                        <div class="mt-2">
                            <button class="btn btn-primary d-block w-50 mx-auto text-center btn-sm mt-1"
                                    style="border: #65b530"
                                    type="submit">{{ __('admin/ui.accessUser') }}</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div>
                    <div class="text-muted text-center" style="">
                        <i class="ik ik-info text-success"></i>
                        {{ __('admin/ui.securityMessage') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
