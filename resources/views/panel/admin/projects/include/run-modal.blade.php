<div class="modal fade" id="scenarioRunner" role="dialog" aria-labelledby="scenarioRunnerTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="scenarioRunnerTitle">Scenario</h5>
                    <button type="button" class="btn close" data-dismiss="modal" aria-label="Close"
                         style="padding: 0px 20px;font-size: 20px;">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="all-scenarios">
                         @if(isset($cyRunners))
                              @include('panel.admin.projects.include.scenario')
                         @endif
                    </div>
               </div>
         </div>
     </div>
 </div>
 