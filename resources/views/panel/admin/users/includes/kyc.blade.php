<div class="">
    @php
        @$kyc_record = null;
        if (@$user_kyc && isset($user_kyc->details) && @$user_kyc->details != null) {
            @$kyc_record = json_decode(@$user_kyc->details, true);
        }
    @endphp
    <div class="card-body">
        {{-- Status --}}
        @if(isset($user_kyc) && @$user_kyc->status == \App\Models\UserKyc::STATUS_VERIFIED)
            <div class="alert alert-success">
                User Verification request has been verified!
            </div>
        @elseif(isset($user_kyc) && @$user_kyc->status == \App\Models\UserKyc::STATUS_REJECTED)
            <div class="alert alert-danger">
                User Verification request has been rejected!
            </div>
        @elseif(isset($user_kyc) && @$user_kyc->status == \App\Models\UserKyc::STATUS_UNDER_APPROVAL)
            <div class="alert alert-warning">
                User submited Verification request, Please validate and take appropriated action.
            </div>
        @else
            <div class="alert alert-info">
                <i class="ik ik-alert-triangle"></i> Verification request isn't submitted yet!
            </div>
        @endif

        <form action="{{ route('panel.admin.users.update-kyc-status',$user->id) }}" method="POST" class="form-horizontal">
            @csrf
            <input id="status" type="hidden" name="status" value="">
            <input type="hidden" name="user_id" value="{{ @$user->id }}">
            <div class="row">
                <div class="col-md-6 col-6"><label>{{ __('admin/ui.document') }}</label>
                    <br>
                    <h5 class="strong text-muted">{{ @$kyc_record['document_type'] ?? '--' }}</h5>
                </div>
                <div class="col-md-6 col-6"><label>{{ __('admin/ui.unique_identifier') }}</label>
                    <br>
                    <h5 class="strong text-muted">{{ Str::limit(@$kyc_record['document_number'] ?? '--', 25) }}</h5>
                </div>
                <div class="col-md-6 col-6"><label>{{ __('admin/ui.front_side') }}</label>
                    <br>
                    @if (@$kyc_record != null && @$kyc_record['document_front'] != null)
                        <a href="{{ asset(@$kyc_record['document_front']) }}" target="_blank"
                           class="btn btn-outline-danger">View Attachment</a>
                        <a href="{{ asset(@$kyc_record['document_front']) }}"  data-toggle="modal" data-target="#filePreviewModal" class="open-modal btn btn-outline-danger">Preview
                        </a>
                    @else
                        <button disabled class="btn btn-secondary">Not Submitted</button>
                    @endif
                </div>
                <div class="col-md-6 col-6"><label>{{ __('admin/ui.back_side') }}</label>
                    <br>
                    @if (@$kyc_record != null && @$kyc_record['document_back'] != null)
                        @if (@$kyc_record != null && @$kyc_record['document_back'] != null)
                            <a href="{{ asset(@$kyc_record['document_back']) }}" target="_blank"
                               class="btn btn-outline-danger">View Attachment</a>
                            <a href="{{ asset(@$kyc_record['document_back']) }}"  data-toggle="modal" data-target="#filePreviewModal" class="open-modal btn btn-outline-danger">Preview
                            </a>
                        @else
                            <button disabled class="btn btn-secondary">Not Submitted</button>
                        @endif
                    @else
                        <button disabled class="btn btn-secondary">Not Submitted</button>
                    @endif
                </div>

                <hr class="m-2">
                @if (auth()->user()->hasRole('admin'))
                    @if (isset($user_kyc) && @$user_kyc->status == \App\Models\UserKyc::STATUS_VERIFIED)
                        <div class="col-md-12 col-12 mt-5">
                            <label>{{ __('admin/ui.note') }}</label>
                            <textarea class="form-control" name="remark"
                                      type="text">{{ @$Verification['admin_remark'] ?? '' }}</textarea>
                            <button type="submit" class="btn btn-danger mt-2 btn-lg reject">Reject</button>
                        </div>
                    @elseif(isset($user_kyc) && @$user_kyc->status == \App\Models\UserKyc::STATUS_REJECTED)
                        <div class="col-md-12 col-12 mt-5">
                            <button type="submit" class="btn btn-warning mt-2 btn-lg reset">Reset</button>
                        </div>
                    @elseif(isset($user_kyc) && @$user_kyc->status == \App\Models\UserKyc::STATUS_UNDER_APPROVAL)
                        <div class="col-md-12 col-12 mt-5"><label>{{ __('admin/ui.rejection_reason') }} (If
                                Any)</label>
                            <textarea class="form-control" name="remark"
                                      type="text">{{ @$kyc_record['admin_remark'] ?? '' }}</textarea>
                            <button type="submit" class="btn btn-danger mt-2 btn-lg reject">Reject</button>
                            <button type="submit"
                                    class="btn btn-success accept ml-5 accept mt-2 btn-lg">Accept
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </form>
    </div>
</div>
<div class="">
    <form class="" action="{{ route('panel.admin.users.verified-status', $user->id) }}" method="get">
        @csrf
        <input type="hidden" name="request_with" value="create">
        <div class="card-body">
            <div class="row border-top">

                {{--                <div class="col-md-12">--}}
                <div class="col-md-6  mt-4"><label>Email:</label>
                    <span
                        class="badge {{ @$user->email_verified_at == '' ? 'badge-pill badge-warning' : 'badge-pill text-leaf badge-primary' }}">
                           {{ @$user->email_verified_at == null ? 'Not Verified' : 'Verified' }}
                    </span>
                    <br>
                    <div class="form-group mt-2">
                        <input type="date" class="form-control" name="email_verified_at"
                               value="{{\Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d')}}">
                    </div>
                </div>

                <div class="col-md-6 mt-4"><label>Phone:</label>
                    <span
                        class="badge {{ @$user->phone_verified_at == '' ? 'badge-pill badge-warning' : 'badge-pill text-leaf badge-primary' }}">
                          {{ @$user->phone_verified_at == '' ? 'Not Verified' : 'Verified' }}
                 </span>
                    <br>
                    <div class="form-group mt-2">
                        <input type="date" class="form-control" name="phone_verified_at"
                               value="{{\Carbon\Carbon::parse($user->phone_verified_at)->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button type="submit"
                        class="btn btn-primary">{{ __('admin/ui.create') }}</button>
            </div>
        </div>
    </form>
</div>
{{--preview modal--}}
<div class="modal fade" id="filePreviewModal" tabindex="-1" role="dialog" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filePreviewModalLabel">File Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Image container -->
                <div id="previewImageContainer" >
                    <!-- Dynamic image will be added here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--preview modal--}}
