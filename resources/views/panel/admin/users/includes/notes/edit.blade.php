<div class="modal fade" id="editModalCenter" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('admin/ui.editNote') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="editNoteForm" method="post" >
                    @csrf
                    <input type="hidden" name="type" value="User">
                    <input type="hidden" name="type_id" id="note-type_id">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="form-group {{ @$errors->has('title') ? 'has-error' : '' }}">
                                <label for="title" class="control-label">{{ __('admin/ui.title') }}<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="title" type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."id="note-title"
                                    placeholder="Enter Title" required>
                            </div>
                            <div class="form-group {{ @$errors->has('category_id') ? 'has-error' : '' }}">
                                <label for="category_id"
                                    class="control-label">{{ __('admin/ui.category') }}</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="" readonly>Select Category</option>
                                    @foreach (@$categories as $category)
                                        <option value="{{ @$category->id }}"
                                            @if (@$category->id == @$user->category_id) selected @endif>{{ @$category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group {{ @$errors->has('description') ? 'has-error' : '' }}">
                                <label for="description"
                                    class="control-label">{{ __('admin/ui.description') }}<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" required rows="5" name="description" type="textarea" id="note-description"
                                    placeholder="Enter Description"></textarea>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">{{ __('admin/ui.update') }}</button>
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
