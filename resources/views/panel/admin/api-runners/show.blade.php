@extends('layouts.main')
@section('title', 'Projects')
@section('content')
@php
/**
* Project
*
* @category ZStarter
*
* @ref zCURD
* @author Defenzelite <hq@defenzelite.com>
    * @license https://www.defenzelite.com Defenzelite Private Limited
    * @version <zStarter: 1.1.0>
        * @link https://www.defenzelite.com
        */
        $breadcrumb_arr = [
            ['name'=>'Projects', 'url'=> "javascript:void(0);", 'class' => 'active']
        ];
        @endphp
        <!-- push external head elements to head -->
        @push('head')
        <link href="https://cdn.jsdelivr.net/npm/jsoneditor@9.5.6/dist/jsoneditor.min.css" rel="stylesheet" type="text/css">
        <style>
            .ace_editor.ace-jsoneditor {
                height: 50vh !important;
            }
            .border-completed {
                border-right: 1px solid gray;
            }
        </style>
        @endpush
        <div class="container-fluid">
            <!-- start message area-->
            <div class="ajax-message text-center"></div>
            <!-- end message area-->
            <div class="row">
                <div class="col-md-4">
                    <div class="card" style="position: sticky;top: 80px">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h6 class="mb-0 fw-700">{{$project->name}}</h6>
                                    <div>Runners</div>
                                    @if($groupProject !== "" && $groupProject !== null)
                                    <div class="row ml-0 mt">
                                        <div class="text-muted d-flex align-items-center mr-5">
                                            <i class="fa-solid fa-layer-group"></i> <!-- Assuming you're using the correct Font Awesome classes for the "layer-group" icon -->
                                        </div>
                                        <h6 class="mb-0 fw-700">{{$groupProject->name ?? ""}}</h6>
                                    </div>
                                @endif
                                </div>
                                <div class="col-auto d-flex justify-content-end">
                                    <div class="runner-controls d-flex justify-content-end">    
                                        <button id="pauseButton" class="btn btn-danger" onclick="pauseScenario()">Pause</button>
                                        <button id="replayButton" class="btn btn-primary" style="display: none;" onclick="replayScenario()">Replay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height: 60vh;overflow-y: auto;">
                                @if($getAllGroup !== "") <!-- Check if $getAllGroup is not empty -->
                                @foreach ($getAllGroup as $group)
                                @php
                                    $groupRunners = $runners->where('group_id', $group->id);
                                    @endphp
                                        @if($groupRunners->count() > 0) <!-- Check if $groupRunners is not empty -->
                                            <div class="row ml-0">
                                                <div class="text-muted d-flex align-items-center mr-5">
                                                    <i class="fa-solid fa-layer-group"></i> <!-- Assuming you're using the correct Font Awesome classes for the "layer-group" icon -->
                                                </div>
                                                <h6 class="mb-0 fw-700">{{$group->name}}</h6>
                                            </div>
                                            <hr>
                                            @foreach ($groupRunners as $runner)
                                           
                                                <div>
                                                    <div>
                                                        <h6 class="mb-1">
                                                            {{$runner->title}}
                                                        </h6>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div>
                                                            <strong class="mb-0 text-dark fw-700">
                                                                {{$runner->getPrefix()}}
                                                            </strong>
                                                        </div>
                                                        <div class="runner-api-sequence-{{$runner->id}}">
                                                            <i class="fa fa-spinner text-warning fa-spin"></i> In Queue
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="m-1 p-0">
                                            @endforeach
                                        @endif
                                    @endforeach
                               
                                @endif
                               
                            @if($getAllGroup === "")
                            @if($runners->count() > 0)
                                @foreach ($runners as $runner)
                                <div>
                                    <div>
                                        <h6 class="mb-1">
                                            {{$runner->title}}
                                        </h6>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <strong class="mb-0 text-dark fw-700">
                                                {{$runner->getPrefix()}}
                                            </strong>
                                        </div>
                                        <div class="runner-api-sequence-{{$runner->id}}">
                                             <i class="fa fa-spinner text-warning fa-spin"></i> In Queue
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-1 p-0">
                                @endforeach
                            @else
                            <div class="Response">
                                <div class="text-center">
                                    <p class="mt-1">No Logs Yet!</p>
                                </div>
                            </div>  
                            @endif
                            @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 border-completed">
                                    <div class="status-count" id="completedCount">
                                        <h6><strong>Completed</strong></h6>
                                        <div id="completedValue" class="count-value">0</div>
                                    </div>
                                </div>
                                <div class="col-md-4 border-completed">
                                    <div class="status-count" id="failedCount">
                                        <h6><strong>Failed</strong></h6>
                                        <div id="failedValue" class="count-value">0</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="status-count" id="queuedCount">
                                        <h6><strong>In Queue</strong></h6>
                                        <div id="queuedValue" class="count-value">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3" id="ajax-container" >
                        
                        <div class="col-md-12 col-12 loging-ai-tool">
                            <div class="row mt-3" id="hide-container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="Response">
                                            <div class="text-center">
                                                <img src="{{asset('panel/admin/ai-loading.gif')}}" alt="" style="width:60px;" srcset="">
                                                <p class="mt-1">Our AI tool is processing Please Wait...</p>
                                            </div>
                                       </div>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel">API Response</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div id="jsonArea">
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- push external js -->
        @push('script')
        <script src="https://cdn.jsdelivr.net/npm/jsoneditor@9.5.6/dist/jsoneditor.min.js"></script>
        <script>
            $(document).on('submit','.ajaxForm',function(e){
                e.preventDefault();
                let route = $(this).attr('action');
                let method = $(this).attr('method');
                let data = new FormData(this);
                let response = postData(method,route,'json',data,null,null,1,null,'not-reload');
            })
        </script>
        
        <script>
            var runner_arr = <?php echo json_encode($runners->pluck('id')->toArray()); ?>;
            var runners_count =  <?php echo json_encode($runners->pluck('id')->count()); ?>;
            var project_id ="<?php echo $project->id; ?>";
            var active_thread = 0; 
            
            runner_arr.forEach(element => {
                updateCounts('queued-total');
            });

            var isPaused = false;
            
            function pauseScenario() {
                isPaused = true; // Set the flag to pause the scenario
                document.getElementById("pauseButton").style.display = "none";
                document.getElementById("replayButton").style.display = "inline-block";
                document.getElementById("hide-container").style.display = "none";
                
            }
                
            function replayScenario() { 
                isPaused = false; // Unpause the scenario
                document.getElementById("pauseButton").style.display = "inline-block";
                document.getElementById("replayButton").style.display = "none";
                document.getElementById("hide-container").style.display = "block";
                getApiScenario(project_id, runner_arr[active_thread]); // Restart the scenario
            }
                
                
            document.getElementById("pauseButton").addEventListener("click", pauseScenario);
            document.getElementById("replayButton").addEventListener("click", replayScenario);
            
            function getApiScenario(project_id, sequence) {
                $.ajax({
                    url: "{{route('admin.api-runners.run-bulk-scenario')}}",
                    method: "post",
                    data: {
                        project_id: project_id,
                        sequence: sequence,
                    },
                    success: function(res) {
                        if (!isPaused) { // Check if the scenario is not paused
                            if (res.status == 'success') {

                                // $('#ajax-container').prepend(res.view);
                                $('#ajax-container').prepend(res.view);
                                $('.runner-api-sequence-' + runner_arr[active_thread]).html("<i class='fa fa-check-circle text-success'></i> Completed");
                                
                                updateCounts('queued-sub');
                                setTimeout(() => {
                                    ++active_thread;
                                    if (runners_count >= active_thread) {
                                        getApiScenario("{{$project->id}}", runner_arr[active_thread]);
                                    }
                                }, 2500);
                            } else {
                                $('.loging-ai-tool').hide();
                            document.getElementById("pauseButton").style.display = "none";
                            document.getElementById("replayButton").style.display = "none";
                            document.getElementById("hide-container").style.display = "none";
                            }
                        }
                    }
                });
            }

            function updateCounts(status) {
                switch (status) {
                    case 'completed':
                        var completedCount = parseInt($('#completedValue').text()) + 1;
                        $('#completedValue').text(completedCount);
                        break;
                    case 'failed':
                        var failedCount = parseInt($('#failedValue').text()) + 1;
                        $('#failedValue').text(failedCount);
                        break;
                    case 'queued-total':
                        var queuedCount = parseInt($('#queuedValue').text()) + 1;
                        $('#queuedValue').text(queuedCount);
                        break;
                    case 'queued-sub':
                    var queuedCount = parseInt($('#queuedValue').text()) - 1;
                    $('#queuedValue').text(queuedCount);
                    break;
                    default:
                        break;
                }
            }

            $(document).ready(function(){
                if(runners_count > active_thread){
                    getApiScenario(project_id, runner_arr[active_thread]);
                }
            });

            function showResponse(id){
                $('#responseModalLabel').text('#APIR' + id);
                var responseText = $('.jsonOutputBody-' + id).val();

                // Try to parse and load JSON to the editor
                if (!editor) {
                    // Initialize the JSON editor only when needed
                    editor = new JSONEditor(document.getElementById('jsonArea'), {
                        mode: 'code'
                    });
                }
                editor.set(JSON.parse(responseText)); // Load the JSON into the editor
                $('#responseModal').modal('show');
            }
            $('#responseModal').on('hidden.bs.modal', function (e) {
                if (editor) {
                    editor.destroy(); // Destroy the editor when the modal is closed.
                    editor = null;
                }
            });

            function getJson() {
                try {
                    var data = $('#jsonOutput').val();
                    var parsedData = JSON.parse(data);
                    editor.set(parsedData);
                    $('.api-console').addClass('d-none');
                    document.getElementById('jsonArea').style.display = 'block';
                } catch (ex) {
                    $('.api-console').html('Wrong JSON Format:' + ex);
                    $('.api-console').removeClass('d-none');
                    document.getElementById('jsonArea').style.display = 'none';
                }
            }

            // initialize
            var editor = new JsonEditor('#jsonArea', '');
        </script>

        @endpush
@endsection