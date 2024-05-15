<div class="modal fade" id="addCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="category-form">
                <input type="hidden" id="category-select-id" value="">
                <div class="modal-body">
                    <input type="hidden" name="category_type_code" value="{{ $category_type_code }}">
                    <input type="hidden" name="level" id="categoryLevelInput" value="1">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" pattern="[a-zA-Z]+.*"
                                    title="Please enter first letter alphabet and at least one alphabet character is required."
                                    name="name" class="form-control" placeholder="Name" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <div class="form-group">
                                <label>Icon</label>
                                <input type="file" name="icon" class="form-control" placeholder="Name"
                                    value="">
                            </div>
                        </div>
                    </div>
                    <div class="ajax-message mb-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
