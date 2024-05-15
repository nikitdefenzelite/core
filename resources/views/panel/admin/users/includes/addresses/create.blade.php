<div class="modal fade" id="addressModalCenter" role="dialog" aria-labelledby="addressModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-address">
                <h5 class="modal-title" id="addressModalCenterLabel">{{ __('admin/ui.addAddress') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.admin.addresses.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ @$user->id }}">
                    <input type="hidden" name="request_with" value="create">
                    <div class="row">
                        <div class="col-12 mx-auto row">
                            <div class="col-md-12">
                                <div class="form-group {{ @$errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name" class="control-label">{{ __('admin/ui.name') }}<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="name" type="text" pattern="[a-zA-Z]+.*"
                                        title="Please enter first letter alphabet and at least one alphabet character is required."
                                        id="name" placeholder="Enter Name" value="" required>
                                </div>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <div class="form-group {{ @$errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="phone"
                                        class="control-label">{{ __('admin/ui.contact_number') }}<span
                                            class="text-danger">*</span></label>
                                    <input name="phone" min="0" required type="number" name="phone"
                                    minlength="10"  maxlength="12" pattern="^[0-9]*@$" id="address_phone" class="form-control "
                                        placeholder="Enter Number">
                                </div>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <div class="form-group {{ @$errors->has('pincode') ? 'has-error' : '' }}">
                                    <label for="Pincode" class="control-label">{{ __('admin/ui.pincode') }}<span
                                            class="text-danger">*</span></label>
                                    <input required type="number" min="0" name="pincode" id="pincode"
                                        class="form-control " placeholder="Enter Pincode">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group {{ @$errors->has('type') ? 'has-error' : '' }}">
                                    <label for="phone" class="control-label">{{ __('admin/ui.addrType') }}<span
                                            class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 row" style="margin-top: -15px">
                                <div class="col-6">
                                    <div class="form-check" style="line-height: 25px;">
                                        <input id="home" name="type" value="0" type="radio"
                                            class="form-check-input" required="">
                                        <label class="form-check-label"
                                            for="home">{{ __('admin/ui.home') }}</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check mb-2" style="line-height: 25px;">
                                        <input id="office" name="type" value="1" type="radio"
                                            class="form-check-input" required="">
                                        <label class="form-check-label"
                                            for="office">{{ __('admin/ui.office') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group {{ @$errors->has('address_1') ? 'has-error' : '' }}">
                                    <label for="address_1" class="control-label">{{ __('admin/ui.address') }}<span
                                            class="text-danger">*</span></label>
                                    <input name="address_1" type="text"
                                        title="Please enter first letter alphabet and at least one alphabet character is required."name="address_1"
                                        id="address_1" required class="form-control " placeholder="Enter Address">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group {{ @$errors->has('address_2') ? 'has-error' : '' }}">
                                    <label for="address_2" class="control-label">{{ __('admin/ui.address') }}
                                        2</label>
                                    <input name="address_2" type="text"
                                        title="Please enter first letter alphabet and at least one alphabet character is required."
                                        name="address_2" id="address_2" class="form-control "
                                        placeholder="Enter Address 2">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ @$errors->has('country_id') ? 'has-error' : '' }}">
                                    <label for="country" class="form-label">{{ __('admin/ui.country') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select form-control select2" id="country"
                                            required name="country_id">
                                            <option value="" selected>Select Country</option>
                                        @foreach (@$countries as $country)
                                            <option value="{{ @$country->id }}">
                                                {{ @$country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid country.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ @$errors->has('state_id') ? 'has-error' : '' }}">
                                    <label for="state" class="form-label">{{ __('admin/ui.state') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select form-control select2" required
                                            id="state" name="state_id">
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a valid state.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ @$errors->has('city_id') ? 'has-error' : '' }}">
                                    <label for="city" class="form-label">{{ __('admin/ui.city') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select form-control select2" id="city"
                                            name="city_id">
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a valid city.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="form-group text-right">
                                    <button type="submit"
                                        class="btn btn-primary">{{ __('admin/ui.create') }}</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{ __('admin/ui.close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
