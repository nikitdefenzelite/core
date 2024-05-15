<div class="row">
     <div class="col-md-4">
          <div class="bg-gray p-2" style="height: 200px;overflow: auto">
               <div>
                    @foreach ($cyRunners as $cyRunner)
                         <a href="javascript:void(0)">{{$cyRunner->getPrefix()}}</a>
                    @endforeach
               </div>
          </div>
     </div>
     <div class="col-md-8">
          <div class="Response">
               <div class="text-center">
                    <img src="{{asset('panel/admin/ai-loading.gif')}}" alt="" style="width:10%;" srcset="">
                    <p>Our AI tool is processing please wait...</p>
               </div>
          </div>
     </div>
</div>