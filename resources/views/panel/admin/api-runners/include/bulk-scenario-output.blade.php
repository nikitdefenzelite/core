<div class="col-md-12 col-12">
  <div class="card mb-2">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center">
                <i class="ik ik-terminal fa-lg text-dark mr-2"></i>
                <h6 title="File Name" class="mb-0 fw-800 text-dark">{{ isset($response['api_runner']['title']) ? $response['api_runner']['title'] : '' }}</h6>
            </div>
            <div class="d-flex align-items-center">
                @switch(@$response['response']['payload']['status_code'])
                    @case(200)
                     <div>
                        <span class="badge badge-success fw-800 fs-20">
                            <i class="ik ik-check-circle text-white"></i>
                            Success
                        </span>
                        <!-- <div class="fw-700 text-left text-muted">Response: 200</div> -->
                     </div>
                     <script>
                        updateCounts('completed');
                    </script>
                        @break
                    @case(201)
                    <div>
                        <div class="badge badge-success fw-800 fs-20">
                            <i class="ik ik-check-circle fa-2x text-success"></i>
                            Success
                        </div>
                        <div class="fw-700 text-left text-muted">Response: 201</div>
                     </div>
                     <script>
                        updateCounts('completed');
                    </script>
                        @break
                    @case(204)
                    <div>
                        <div class="badge badge-success fw-800 fs-20">
                            <i class="ik ik-check-square fa-2x text-success"></i>
                            Success
                        </div>
                        <div class="fw-700 text-left text-muted">Response: 204</div>
                     </div>
                     <script>
                        updateCounts('completed');
                    </script>
                        @break
                    @case(400)
                    @case(401)
                    @case(403)
                    @case(404)
                    @case(405)
                    @case(411)
                    @case(500)
                    <div>
                        <div class="badge badge-danger fw-800 fs-20">
                            <i class="ik ik-alert-triangle fa-1x text-white"></i>
                            Error
                        </div>
                        <div class="fw-700 text-left text-muted">Response: {{$response['response']['payload']['status_code']}}</div>
                     </div>
                     <script>
                        updateCounts('failed');
                    </script>   
                        @break
                    @default
                    <div>
                        <div class="badge badge-danger fw-800 fs-20">
                            <i class="ik ik-alert-circle fa-1x text-warning"></i>
                            Error
                        </div>
                        <div class="fw-700 text-left text-muted">Response: {{$response['response']['payload']['status_code']}}</div>
                     </div>
                     <script>
                        updateCounts('failed');
                    </script>
                      
                @endswitch
            </div>
        </div>

        <div title="Group Name" class="alert alert-secondary d-flex align-items-center mb-3 px-2 py-1 fw-800">
            ~ / {{ isset($response['api_runner']['group']) ? $response['api_runner']['group'] : '' }}
        </div>
        
        <div class="alert alert-light api-console p-4 d-none">
              <textarea name="" id="jsonOutput" cols="30" rows="10" class="w-100 jsonOutputBody-{{$response['api_runner']['id']}}">
                  {!! nl2br(e($response['response']['payload']['response'])) !!}
              </textarea>
        </div>

        <div class="row" >
            <div class="col-md-6 d-flex">
                <!-- View Response Button -->
                <button type="button" title="View Response" onclick="showResponse('{{$response['api_runner']['id']}}')" class="btn btn-primary mr-2">
                    <i class="ik ik-eye"></i>
                </button>
             

                <form action="{{ url('admin/upload/task') }}" method="post" enctype="multipart/form-data" class="ajaxForm" id="ProjectForm">
                    @csrf
                   <input type="hidden" name="project_id" value="{{$response['project_response']['project_register_id']}}">
                   <input type="hidden" name="task_description" value="{{$response['response']['payload']['response']}}">

                   <button type="submit" title="Error Task Upload" id="" class="btn btn-secondary">
                    <i class="ik ik-external-link"></i>
                   </button>    
                </form>
            </div>
        </div>
      </div>
  </div>
</div>
