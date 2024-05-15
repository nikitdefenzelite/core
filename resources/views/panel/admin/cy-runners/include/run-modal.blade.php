<div class="modal fade" id="scenarioRunner" role="dialog" aria-labelledby="scenarioRunnerTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="scenarioRunnerTitle"></h5>
                    <button type="button" class="btn close" data-dismiss="modal" aria-label="Close"
                         style="padding: 0px 20px;font-size: 20px;">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
               <div class="modal-body">
                    <div class="all-scenarios">
                         @if(isset($cyRunners))
                         <div class="col-md-12 ">
                              <div class="Response">
                                   <div class="text-center" style="margin-top:15vh">
                                        <img src="{{asset('panel/admin/ai-loading.gif')}}" alt="" style="height: 75px;object-fit: contain" srcset="">
                                        <h6 class="fw-800 mt-3">Running Test Case Automation</h6>
                    
                                        <p class="text-muted fw-700">
                                             ~ Contacting www.zstarter.com
                                        </p>

                                        <br>

                                        <i class="fa fa-spinner fa-spin"></i>
                                   </div>
                              </div>
                         </div>
                         @endif
                    </div>
               </div>
         </div>
     </div>
 </div>
 