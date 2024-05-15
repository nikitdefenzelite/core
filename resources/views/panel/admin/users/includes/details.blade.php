<div class="">
    <div class="card-body">

        <form action="{{ route('panel.admin.users.update', $user->id) }}" method="POST" class="form-horizontal ">
            @csrf
            <input type="hidden" name="request_with" value="update">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">{{ __('admin/ui.first_name') }}<span class="text-red">*</span></label>
                        <input required type="text" pattern="[a-zA-Z]+.*"
                            title="Please enter first letter alphabet and at least one alphabet character is required."
                            title="Please enter first letter alphabet and at least one alphabet character is required."
                            title="Please enter first letter alphabet and at least one alphabet character is required."
                            placeholder="First Name" class="form-control" name="first_name" id="name"
                            value="{{ @$user->first_name }}">
                    </div>
                </div> pattern="[a-zA-Z]+.*"
                title="Please enter first letter alphabet and at least one alphabet character is required."
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="lname">{{ __('admin/ui.last_name') }}<span class="text-red">*</span></label>
                        <input required type="text" pattern="[a-zA-Z]+.*"
                            title="Please enter first letter alphabet and at least one alphabet character is required."
                            title="Please enter first letter alphabet and at least one alphabet character is required."
                            placeholder="Last Name" class="form-control" name="last_name" id="lname"
                            value="{{ @$user->last_name }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">{{ __('admin/tooltip.email') }}<span class="text-red">*</span></label>
                        <input required type="email" placeholder="test@test.com" class="form-control" name="email"
                            id="email" value="{{ @$user->email }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">{{ __('admin/tooltip.phone') }}</label>
                        <input type="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" min="0" minlength="10"
                            maxlength="10" placeholder="123-45-678" id="phone" name="phone" class="form-control"
                            value="{{ @$user->phone }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dob">{{ __('admin/ui.time_dob') }}</label>
                        <input class="form-control" type="date" max="{{ now()->format('Y-m-d') }}" name="dob"
                            placeholder="Select your date" value="{{ @$user->dob }}" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">{{ __('admin/tooltip.status') }}<span class="text-danger">*</span>
                        </label>
                        <select required name="status" class="form-control select2">
                            <option value="" readonly>{{ __('admin/tooltip.Select Status') }}</option>
                            @foreach (@$statuses as $key => $status)
                                <option value="{{ @$key }}" @selected(@$user->status == @$key)>
                                    {{ @$status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="country">{{ __('admin/tooltip.country') }}</label>
                        <select name="country_id" id="country" class="form-control select2">
                            <option value="" readonly>{{ __('admin/tooltip.Select Country') }}</option>
                            @foreach (\App\Models\Country::all() as $country)
                                <option value="{{ @$country->id }}"
                                    @if (@$user->country_id != null) {{ @$country->id == @$user->country_id ? 'selected' : '' }} @elseif(@$country->name == 'India') selected @endif>
                                    {{ @$country->name }}</option>
                            @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="state">{{ __('admin/tooltip.state') }}</label>
                        <select name="state_id" id="state" class="form-control select2">
                            @if (@$user->state != null)
                                <option required value="{{ @$user->state }}" selected>{{ @$user->state }}</option>
                            @endif
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">{{ __('admin/tooltip.city') }}</label>
                        <select name="city_id" id="city" class="form-control select2">
                            @if (@$user->city != null)
                                <option required value="{{ @$user->city }}" selected>{{ @$user->city }}</option>
                            @endif
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pincode">{{ __('admin/tooltip.pincode') }}</label>
                        <input id="pincode" type="number" class="form-control" name="pincode"
                            placeholder="Enter Pincode" value="{{ @$user->pincode ?? old('pincode') }}">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="role" required>{{ __('admin/tooltip.assignRole') }}<span
                                class="text-red">*</span></label>
                        <select name="role" id="role" class="form-control select2">
                            <option value="" readonly>Select Role</option>
                            @foreach (@$roles as $role)
                                <option value="{{ @$role }}" @selected(@$user->role_name == @$role)>{{ @$role }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">{{ __('admin/ui.time_gender') }}</label>
                        <div class="form-radio">
                            <div class="radio radio-inline">
                                <label>
                                    <input type="radio" name="gender" value="Male"
                                        {{ @$user->gender == 'Male' ? 'selected' : '' }}>
                                    <i class="helper"></i>{{ __('admin/tooltip.Male') }}
                                </label>
                            </div>
                            <div class="radio radio-inline">
                                <label>
                                    <input type="radio" name="gender" value="Female"
                                        {{ @$user->gender == 'Female' ? 'selected' : '' }}>
                                    <i class="helper"></i>{{ __('admin/tooltip.Female') }}
                                </label>
                            </div>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 20px;">
                        <div class="form-check mx-sm-2">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_verified"
                                    class="custom-control-input js-switch switch-input" value="1"
                                    {{ @$user->is_verified == 1 ? 'checked' : '' }}>Verified Profile</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 20px;">
                        <div class="form-check mx-sm-2">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="js-switch switch-input" value="1"
                                    @if (@$user->email_verified_at != null) checked @endif name="email_verified_at">
                                Email verified </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">{{ __('admin/tooltip.address') }}</label>
                        <textarea name="address" name="address" rows="3" class="form-control">{{ @$user->address }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bio">{{ __('admin/ui.bio') }}</label>
                        <textarea name="bio" name="bio" rows="3" class="form-control">{{ @$user->bio }}</textarea>
                    </div>
                </div>

                <div class="text-center">
                    <div style="width: 150px; height: 150px; position: relative" class="mx-auto">
                        <img src="{{ @$user && @$user->avatar ? @$user->avatar : asset('panel/admin/default/default-avatar.png') }}"
                            class="rounded-circle" width="150"
                            style="object-fit: cover; width: 150px; height: 150px" />
                        <button class="btn btn-dark rounded-circle position-absolute"
                            style="width: 30px; height: 30px; padding: 8px; line-height: 1; top: 0; right: 0"
                            data-toggle="modal" data-target="#updateProfileImageModal"><i
                                class="ik ik-camera"></i></button>

                    </div>
                    <div class="mt-2">
                        <h5>{{ @$user->full_name }}</h5>
                    </div>
                </div>

            </div>
    </div>
