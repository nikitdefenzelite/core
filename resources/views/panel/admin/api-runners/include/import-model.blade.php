<div class="modal fade" id="importProjectModal" tabindex="-1" role="dialog" aria-labelledby="importProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importProjectModalLabel">Import Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="projectSelectionForm" action="" type='post'>
                <div class="modal-body">
                    {{-- <div class="form-group">
                        <label for="postmanApiKey">Api Key <span class="text-danger">*</span></label>
                        <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                            Generate an API key in Postman: Login, go to settings, click "API key," name it, and generate. eg. PMAK-661e0447f52300000198a155-bd288d4deb6d022db86d9c6ce55eed8088
                        </div>
                        <input type="text" class="form-control" id="postmanApiKey" name="postmanApiKey" placeholder="Enter Postman Collection API Key" required>
                    </div> --}}
                    <div class="form-group">
                        <label for="directoryName">Directory Name <span class="text-danger">*</span></label>
                        <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                            In Postman, use the collection name "zTerminal."
                        </div>
                        <input type="text" class="form-control" id="directoryName" name="directoryName" placeholder="Enter Postman Collection Directory Name" required>
                    </div>

                    
                    <label for="system_variable_payload" class="control-label"> Postman Payloads<span
                        class="text-danger">*</span></label>
                    <div class="form-group {{ $errors->has('postman_payload') ? 'has-error' : '' }}">
                        <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                            In Postman, use the collection's base URL: https://zterminal.dze-labs.xyz/api.
                        </div>
                        <input type="text" required class="form-control" name="postman_payload[project_repo_url]" type="url" id="postman_payload"
                                        value="{{ old('postman_payload', '') }}" placeholder="Enter Project Repo URL">
                    </div>
                        
                    <div class="form-group {{ $errors->has('postman_payload') ? 'has-error' : '' }}">
                        <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                            In Postman, utilize the collection's Bearer Token, e.g., 1306|QDQwFWSYlAuEoqsC6YCZPtkIYBfuHaurjmucriX3b617212c.
                        </div>
                        <input type="text" required class="form-control" name="postman_payload[access_token]" type="text" id="postman_payload_access_token"
                            value="{{ old('postman_payload', '') }}" placeholder="Enter Access Token">
                    
                    </div>
                    <div class="form-group {{ $errors->has('postman_payload') ? 'has-error' : '' }}">
                        <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                            Generate an API key in Postman: Login, go to settings, click "API key," name it, and generate. eg. PMAK-661e0447f52300000198a155-bd288d4deb6d022db86d9c6ce55eed8088
                        </div>
                        <input type="text" required class="form-control" name="postman_payload[api_key]" type="text" id="postman_payload_api_key"
                            value="{{ old('postman_payload', '') }}" placeholder="Enter API Key">
                    </div>
                    {{-- <div class="form-group">
                        <label for="projectSelect">Select Project <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="projectSelect" name="project_id" required>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                 
                            
               
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitButton">
                        <span id="buttonText">Submit</span> <!-- Initially show submit button text -->
                        <div id="loadingIndicator" style="display: none;">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
