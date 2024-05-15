<div class="modal fade" id="ContactModalCenter" role="dialog" aria-labelledby="contactModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalCenterLabel">{{ __('admin/ui.addContact') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.admin.contacts.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="request_with" value="create">
                    <input type="hidden" name="type" value="{{ 'User' }}">
                    <input type="hidden" name="type_id" value="{{ @$user->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-6 {{ @$errors->has('first_name') ? 'has-error' : '' }}">
                                    <label for="first_name"
                                        class="control-label">{{ __('admin/ui.first_name') }}<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="first_name" type="text" pattern="[a-zA-Z]+.*"
                                        title="Please enter first letter alphabet and at least one alphabet character is required."
                                        id="first_name" placeholder="Enter First Name" value="" required>
                                    {{-- <input class="form-control" name="first_name" type="text" pattern="[a-zA-Z]+.*" title="Please enter first letter alphabet and at least one alphabet character is required." id="first_name" placeholder="Enter First Name" value="{{ isset(@$user->name) ? @$user->name : ''}}" required> --}}
                                </div>
                                <div class="form-group col-md-6 {{ @$errors->has('last_name') ? 'has-error' : '' }}">
                                    <label for="last_name" class="control-label">{{ __('admin/ui.last_name') }}<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="last_name" type="text" pattern="[a-zA-Z]+.*"
                                        title="Please enter first letter alphabet and at least one alphabet character is required."
                                        id="last_name" placeholder="Enter Last Name" value="" required>
                                    {{-- <input class="form-control" name="last_name" type="text" pattern="[a-zA-Z]+.*" title="Please enter first letter alphabet and at least one alphabet character is required." id="last_name" placeholder="Enter Last Name"  value="{{ isset(@$user->last_name) ? @$user->last_name : ''}}" required> --}}
                                </div>

                                {{-- <div class="form-group col-md-6 {{ @$errors->has('job_title') ? 'has-error' : ''}}">
                                    <label for="job_title" class="control-label">{{ 'Job Title' }}</label>
                                    <input class="form-control" name="job_title" type="text" id="job_title" placeholder="Enter Job Title" value="{{ isset(@$user->job_title) ? @$user->job_title : ''}}" required>
                                </div> --}}



                                <div class="form-group col-md-6 {{ @$errors->has('job_title') ? 'has-error' : '' }}">
                                    <label for="job_title" class="control-label">{{ __('admin/ui.category') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2" name="job_title" id="" required>
                                        <option value="" readonly>Select Category</option>
                                        @foreach ($jobTitleCategories as $category)
                                            <option value="{{ @$category->id }}">{{ @$category->name }}</option>
                                        @endforeach
                                    </select>
                                </div> 

                                {{-- <div class="form-group col-md-6 {{ @$errors->has('category_id') ? 'has-error' : '--' }}">
                                    <label for="category_id"
                                        class="control-label">{{ __('admin/ui.category') }}</label>
                                    <select class="form-control select2" tabindex="-1" name="category_id">
                                        <option value="" readonly>Select Category</option>
                                        @foreach (@$categories as $category)
                                            <option value="{{ @$category->id }}">{{ @$category->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}


                                <div class="form-group col-md-6 {{ @$errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email" class="control-label">{{ __('admin/ui.email') }}<span
                                            class="text-red">*</span></label>
                                    <input class="form-control" name="email" type="email" pattern="[a-zA-Z]+.*"
                                        title="Please enter first letter alphabet and at least one alphabet character is required."
                                        id="email" placeholder="Enter Email" value="" required>
                                    {{-- <input class="form-control" name="email" type="email" id="email" placeholder="Enter Email" value="{{ isset(@$user->email) ? @$user->email : ''}}" required> --}}
                                </div>
                                <div class="form-group col-md-6 {{ @$errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="phone" class="control-label">{{ __('admin/ui.phone') }}<span
                                            class="text-red">*</span></label>
                                    <input class="form-control" min="0" pattern="^[0-9]*$" name="phone"
                                        type="number" id="phone" placeholder="Enter Phone" value="" required>
                                    {{-- <input class="form-control" name="phone" type="number" id="phone" placeholder="Enter Phone" value="{{ isset(@$user->phone) ? @$user->phone : ''}}" required> --}}
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="gender">{{ __('admin/ui.gender') }}<span
                                            class="text-red">*</span></label>
                                    <div class="form-radio form-group">
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" name="gender" value="male" checked>
                                                <i class="helper"></i>{{ __('admin/ui.male') }}
                                            </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" name="gender" value="female">
                                                <i class="helper"></i>{{ __('admin/ui.female') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 mx-auto">
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
