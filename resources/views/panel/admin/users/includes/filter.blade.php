<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="side-slide" style="right: -100%;">
    <div class="filter">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mt-3 mb-0">{{ __('admin/ui.filter') }}</h5>
            <button type="button" class="close off-canvas mt-2 mb-0" data-type="close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('panel.admin.users.index', ['role' => request()->get('role')]) }}" method="get"
                class="d-flex filterForm">
                <input type="hidden" name="role" value="{{ request()->get('role') }}">
                <div class="row">
                    <div class="col-12 form-group mr-2 align-items-center">
                        <label for="">{{ __('admin/ui.status') }}</label>
                        <br>
                        <select class="form-control select2" name="status" id="">
                            <option aria-readonly="true" value=""> All Status</option>
                            @foreach (@$statuses as $key => $status)
                                <option value="{{ @$key }}" @if (request()->has('status') && request()->get('status') == @$key) selected @endif>
                                    {{ @$status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Apply {{ __('admin/ui.filter') }}</button>
                        <a href="<?php @$_SERVER['PHP_SELF']; ?>" id= "reset" type="button" class="btn btn-light ml-2">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
