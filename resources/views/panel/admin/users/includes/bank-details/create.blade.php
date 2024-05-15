<div class="modal fade" id="bankDetailsModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="bankDetailsModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bankDetailsModalCenterLabel">{{ __('admin/ui.add_bank_detail') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.admin.payout-details.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ @$user->id }}">
                    <input type="hidden" name="request_with" value="create">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="form-group {{ @$errors->has('bank_name') ? 'has-error' : '' }}">
                                <label for="bank_name" class="control-label">{{ __('admin/ui.bank') }} <span
                                        class="text-danger">*</span></label>
                                <select class="form-select form-control" name="bank_name" id="bank_name">
                                    @foreach (@\App\Models\PayoutDetail::BANK_NAMES as $key => $bank_name)
                                        <option value="{{ @$key }}">{{ @$bank_name['label'] ?? '--' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">{{ __('admin/ui.accountType') }} <span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-6">
                                <div class="form-check" style="line-height: 25px;">
                                    <input name="type" value="Current" type="radio" class="form-check-input pb-1"
                                        id="current" required="">
                                    <label class="form-check-label mb-1 " for="current">Current</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check mb-2" style="line-height: 25px;">
                                    <input name="type" value="Saving" type="radio" class="form-check-input pb-1"
                                        id="saving" required="">
                                    <label class="form-check-label mb-1 " for="saving">Saving</label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group {{ @$errors->has('type') ? 'has-error' : '' }}">
                                <label for="phone" class="control-label">{{ __('admin/ui.accountHolder') }}<span
                                        class="text-danger">*</span></label>
                                <input name="account_holder_name" required type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."
                                    class="form-control" placeholder="Enter Account Holder Name">
                            </div>

                            <div class="form-group {{ @$errors->has('account_no') ? 'has-error' : '' }}">
                                <label for="account_no" class="control-label">{{ __('admin/ui.accountNumber') }}
                                    <span class="text-danger">*</span></label>
                                <input name="account_no" pattern="[0-9]{9,12}"
                                    title="Please enter a valid account number consisting of 9 to 12 digits."
                                    id="numberInput" required type="number" class="form-control "
                                    placeholder="Enter Account Number">
                            </div>
                            <div class="form-group {{ @$errors->has('ifsc_code') ? 'has-error' : '' }}">
                                <label for="ifsc_code" class="control-label">
                                    {{ __('admin/ui.ifscCode') }}<span class="text-danger">*</span>
                                </label>
                                <input name="ifsc_code" required type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."
                                    name="ifsc_code" id="ifsc_code" class="form-control " placeholder="Enter IFSC Code">
                            </div>
                            <div class="form-group {{ @$errors->has('branch') ? 'has-error' : '' }}">
                                <label for="singin-email">{{ __('admin/ui.branch') }} <span
                                        class="text-danger">*</span></label>
                                <input name="branch" required type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."
                                    class="form-control" placeholder="Enter Branch ">
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"
                                    class="btn btn-primary">{{ __('admin/ui.create') }}</button>
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('admin/ui.close') }}</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Get the input element
    const numberInput = document.getElementById('numberInput');

    // Set the maximum allowed length (e.g., 12 characters)
    const maxLength = 12;
    // Attach an event listener to the input event
    numberInput.addEventListener('input', function() {
        // Trim the input value to the maximum allowed length
        if (numberInput.value.length > maxLength) {
            numberInput.value = numberInput.value.slice(0, maxLength);
        }
    });
</script>
