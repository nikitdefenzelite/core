<style>
    #json {
        display: none;
    }

    .form-group {
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>
<div class="modal fade" id="loadJsonModal" role="dialog" aria-labelledby="loadJsonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loadJsonModalLabel">{{ __('admin/tooltip.Load Json') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                        class="text-muted">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div id="jsoneditor"></div>
                                <!-- <textarea class="form-control" name="json" id="json" cols="30" rows="10">@include('crudgenrator.includes.json-content') </textarea> -->
                                <textarea class="form-control" name="json" id="json" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer mt-4">
                <div class="form-group text-right">
                    <button type="button" id="prefillButton" class="btn btn-primary">Start Prefill</button>
                </div>
            </div>
        </div>
    </div>
</div>
