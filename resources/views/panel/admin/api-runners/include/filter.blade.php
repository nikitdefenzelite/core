<div class="side-slide" style="right: -100%;">
    <div class="filter">
        <div class="card-header d-flex justify-content-between ">
            <h5 class="mt-3 mb-0">Filter</h5>
            <button type="button" class="close off-canvas mt-2 mb-0" data-type="close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.api-runners.index') }}" method="GET" id="TableForm" class="d-flex">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">Status</label>
                        <select id="status" name="status" class="select2 form-control course-filter">
                            <option readonly value="">Select Status</option>
                            <option value="Draft">Draft</option>
                            <option value="Active">Active</option>
                            <option value="Discard">Discard</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label for="">Category</label>
                        @php
                            $apiRunners = \App\Models\ApiRunner::get();
                            $category = \App\Models\Category::get();
                            $category = $category->where('type_id', \App\Models\Category::STATUS_TYPE_APIRUNNER);
                        @endphp
                        <select name="category_id" id="category_id" class="form-control select2">
                            <option value="" readonly>Select Category </option>
                            @foreach ($category as $key => $category)
                                <option value="{{ $category->id }}"@if (request()->has('category_id') && request()->get('category_id') == $key) selected @endif>
                                    {{ $category->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                        <a href="javascript:void(0);" id="reset" type="button" class="btn btn-light ml-2">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
