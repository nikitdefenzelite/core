<div class="modal fade" id="editBankDetailsModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('admin/ui.updateBankDetail') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.admin.payout-details.update') }}" method="post">
                    <input type="hidden" name="id" value="" id="payoutdetailId">
                    <input type="hidden" name="user_id" value="">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="form-group {{ @$errors->has('bank_name') ? 'has-error' : '' }}">
                                <label for="bank_name" class="control-label">{{ __('admin/ui.bank') }} <span
                                        class="text-danger">*</span></label>
                                <select  name="bank_name" id="editbank" class="form-select form-control"
                                        aria-label="Default select example" required>
                                    @foreach (\App\Models\PayoutDetail::BANK_NAMES as $key => $bank_name)
                                        <option value="{{ @$key }}">{{ @$bank_name['label'] ?? '--' }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="">{{ __('admin/ui.accountType') }} <span
                                    class="text-danger">*</span></label>
                            <div class="form-check">
                                <input name="type" value="Current" type="radio" class="form-check-input pb-1"
                                    id="editcurrent" required="">
                                <label class="form-check-label pl-2 mb-1 " for="current">Current</label>
                            </div>
                            <div class="form-check">
                                <input name="type" value="Saving" type="radio" class="form-check-input pb-1"
                                    id="editsaving" required="">
                                <label class="form-check-label pl-2 mb-1 " for="saving">Saving</label>
                            </div>
                            {{-- <div class="d-flex justify-content-around">
                                <div class="form-group {{ @$errors->has('current') ? 'has-error' : ''}}">
                                </div>
                                <div class="form-group {{ @$errors->has('saving') ? 'has-error' : ''}}">

                                </div>
                            </div> --}}
                            <div class="form-group {{ @$errors->has('type') ? 'has-error' : '' }}">
                                <label for="phone" class="control-label">{{ __('admin/ui.accountHolder') }}<span
                                        class="text-danger">*</span></label>
                                <input name="account_holder_name" required type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."class="form-control"
                                    id="editaccount_holder_name" placeholder="Enter Account Holder Name">
                            </div>
                            <div class="form-group {{ @$errors->has('account_no') ? 'has-error' : '' }}">
                                <label for="account_no"
                                    class="control-label">{{ __('admin/ui.accountNumber') }}</label>
                                <input name="account_no" pattern="[0-9]{9,12}"
                                    title="Please enter a valid account number consisting of 9 to 12 digits."
                                    class="form-control" id="editaccount_no" required type="number"
                                    placeholder="Enter Account Number">
                            </div>
                            <div class="form-group {{ @$errors->has('ifsc_code') ? 'has-error' : '' }}">
                                <label for="ifsc_code" class="control-label">
                                    {{ __('admin/ui.ifscCode') }}<span class="text-danger">*</span>
                                </label>
                                <input name="ifsc_code" required type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."
                                    name="ifsc_code" id="editifsc_code" class="form-control editifsc_code"
                                    placeholder="Enter Ifsc Code">
                            </div>

                            <div class="form-group {{ @$errors->has('branch') ? 'has-error' : '' }}">
                                <label for="singin-email">{{ __('admin/ui.branch') }}<span
                                        class="text-danger">*</span></label>
                                <input name="branch" required type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."class="form-control editbranch"
                                    placeholder="Enter Branch" id="editbranch">
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"
                                    class="btn btn-primary">{{ __('admin/ui.update') }}</button>
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
