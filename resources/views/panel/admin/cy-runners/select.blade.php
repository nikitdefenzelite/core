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
        <style>
            .border-completed {
                border-right: 1px solid gray;
            }
            .cy-run-width{
                width: 60px !important;
            }
        </style>
        @endpush
        <div class="container-fluid">
            <!-- start message area-->
            <div class="ajax-message text-center"></div>
            <!-- end message area-->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="position: sticky;top: 80px">
                            <div class="card-header justify-content-between">
                                <div class="row">
                                    <div class="col">
                                        <h6 class="mb-0 fw-700">Cy Scenarios</h6>
                                        <div>{{ $project->name }}</div>
                                    </div>
                                </div>
                                @php
                                $totalRunnersCount = $runners->count();
                                 @endphp
                                <div class="d-flex justify-content-end float-right">
                                    <div class="runner-controls d-flex justify-content-end float-right"> 
                                        <a class="btn btn-primary mr-2 d-flex justify-content-center align-items-center" title="Flow Runner" target="_blank" href="{{ route('admin.cy-runners.get-bulk-scenario', ['project_id' => $project->id, 'group_id' => ""]) }}">
                                            Runner all Cy Scenarios ({{ $totalRunnersCount  }})
                                        </a>   
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="height: 60vh; overflow-hidden: auto;">
                                    @if ($groupProject->isNotEmpty())
                                    <div class="row">
                                        @foreach ($groupProject as $group)
                                        @php
                                            $groupRunners = $runners->where('group_id', $group->id);
                                        @endphp
                                        @if ($groupRunners->count() > 0)
                                            <div class="col-lg-3 col-md-4">
                                                <div class="card shadow-md bg-body rounded">
                                                    <div class="card-body d-flex justify-content-between">
                                                        <div class="state">
                                                            <a href="{{ route('admin.cy-runners.get-group-drag-drop-scenario', ['project_id' => $project->id, 'group_id' => $group->id]) }}" class="text-primary">
                                                                <h3>{{ $groupRunners->count() }}</h3>
                                                            </a>
                                                            <P class="card-subtitle text-muted fw-500">{{ $group->name }}</P>
                                                        </div>
                                                        <div class="mt-4 cy-run-width">
                                                            <a class="btn btn-primary d-block" title="Flow Runner" target="_blank" href="{{ route('admin.cy-runners.get-bulk-scenario', ['project_id' => $project->id, 'group_id' => $group->id]) }}">
                                                                <i class="ik ik-play mr-0"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                        {{-- <div class="col-2">
                                            <div class="card">
                                                <div class="card-body">
                                                   @php
                                                        $totalRunnersCount = $runners->count();
                                                    @endphp
                                                    <h5 class="card-title">All ({{ $totalRunnersCount  }})</h5>
                                                    <a class="btn btn-primary mr-2 d-flex justify-content-center align-items-center" title="Flow Runner" target="_blank" href="{{ route('admin.cy-runners.get-bulk-scenario', ['project_id' => $project->id, 'group_id' => ""]) }}">
                                                        <i class="ik ik-play mr-0"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    
                                    @else
                                        <div>Group Not Found</div>
                                </div>
                                <hr class="m-1 p-0">
                            </div>
                            
                                <div class="Response">
                                    <div class="text-center">
                                        <p class="mt-1">No Logs Yet!</p>
                                    </div>
                                </div>  
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
        
        <!-- push external js -->
        @push('script')

            {{-- <script>
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
                

                function getScenario(project_id,sequence){
                    $.ajax({
                        url: "{{route('admin.cy-runners.run-bulk-scenario')}}",
                        method: "post",
                        data: {
                            project_id: project_id,
                            sequence: sequence,
                        },
                        success: function(res) {
                            if(res.status == 'success'){
                                $('#ajax-container').prepend(res.view);
                                $('.runner-api-sequence-'+runner_arr[active_thread]).html("<i class='fa fa-check-circle text-success'></i> Completed");
                                updateCounts('queued-sub');
                                
                                setTimeout(() => {
                                    ++active_thread;
                                    if(runners_count >= active_thread){
                                        getScenario("{{$project->id}}", runner_arr[active_thread]);
                                        updateCounts('completed');
                                }
                                }, 1000);
                            }else{
                                $('.loging-ai-tool').hide();
                                document.getElementById("pauseButton").style.display = "none";
                                document.getElementById("replayButton").style.display = "none";
                                document.getElementById("hide-container").style.display = "none";
                            }
                        }
                    })
                }
                $(document).ready(function(){
                    if(runners_count > active_thread){
                    getScenario("{{$project->id}}", runner_arr[active_thread]);
                    }
                })

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

            </script> --}}
        @endpush
@endsection
