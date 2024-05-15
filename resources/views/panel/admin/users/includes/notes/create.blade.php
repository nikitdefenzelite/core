<div class="modal fade" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('admin/ui.add_note') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.admin.user-notes.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="request_with" value="create">
                    <input type="hidden" name="type" value="User">
                    <input type="hidden" name="type_id" value="{{ @$user->id }}">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="form-group {{ @$errors->has('title') ? 'has-error' : '--' }}">
                                <label for="title" class="control-label">{{ __('admin/ui.title') }}<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="title" type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."
                                    id="title" placeholder="Enter Title"
                                    value="{{ isset($note->title) ? @$note->title : '' }}" required>
                            </div>
                            <div class="form-group {{ @$errors->has('category_id') ? 'has-error' : '--' }}">
                                <label for="category_id"
                                    class="control-label">{{ __('admin/ui.category') }}</label>
                                <select class="form-control select2" tabindex="-1" name="category_id">
                                    <option value="" readonly>Select Category</option>
                                    @foreach (@$categories as $category)
                                        <option value="{{ @$category->id }}">{{ @$category->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group {{ @$errors->has('description') ? 'has-error' : '--' }}">
                                <label for="description"
                                    class="control-label">{{ __('admin/ui.description') }}<span
                                        class="text-danger">*</span></label>
                                <textarea required class="form-control" rows="5" name="description" type="textarea" id="description"
                                    placeholder="Enter Description">{{ isset($note->description) ? @$note->description : '' }}</textarea>
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
