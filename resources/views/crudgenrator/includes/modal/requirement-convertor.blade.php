<style>
    .form-group {
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>
<div class="modal fade" id="requirementConvertorModal" role="dialog" aria-labelledby="requirementConvertorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requirementConvertorModalLabel">
                    {{ __('admin/tooltip.Requirement Convertor') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                        class="text-muted">&times;</span></button>
            </div>
            <form action="{{ route('crudgen.process-requirement') }}" method="post" id="processForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="requirement" class="control-label">{{ 'Instructions' }}</label>
                                    <textarea required class="form-control" minLength="100" name="requirement" id="requirement" cols="30"
                                        rows="10" placeholder="Enter Your Requirements Here"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <button type="submit" id="proceedButton" class="btn btn-primary">Start Process</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
