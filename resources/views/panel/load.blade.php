<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $deploy_configs->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $deploy_configs->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $deploy_configs->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $deploy_configs->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Name</a></li>                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Project Register  </a></li>                   
                     <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>                                                      </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.deploy_configs.print') }}"  data-rows="{{json_encode($deploy_configs) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>             
                                               
                        <th class="col_1">Name <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="name"></i><i class="ik ik ik-arrow-down desc" data-val="name"></i></div></th>                        <th class="col_2">Project Register  
                             <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="project_register_id"></i><i class="ik ik ik-arrow-down desc" data-val="project_register_id"></i></div></th>                        <th class="col_3">Status <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="status"></i><i class="ik ik ik-arrow-down desc" data-val="status"></i></div></th>                         
                                                                    
                            </tr>
                </thead>
                <tbody>
                    @if($deploy_configs->count() > 0)
                        @foreach($deploy_configs as  $deploy_config)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.deploy_configs.edit', $deploy_config->id) }}" title="Edit Deploy Config" class="btn btn-sm"><li class="dropdown-item p-0">Edit</li></a>
                                            <a href="{{ route('panel.deploy_configs.destroy', $deploy_config->id) }}" title="Delete Deploy Config" class="btn btn-sm delete-item"><li class="dropdown-item p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                <td class="col_1">{{$deploy_config->name }}</td>
                                      <td class="col_2">{{fetchFirst('App\Models\ProjectRegister',$deploy_config->project_register_id,'project_name','--')}}</td>
                                  <td class="col_3">{{$deploy_config->status == 1 ? 'Allowed' : 'Disallowed'}}</td>
                                  
                            </tr>
                            
                        @endforeach
                    @else 
                        <tr>
                            <td class="text-center" colspan="8">No Data Found...</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <div class="pagination">
            {{ $deploy_configs->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($deploy_configs->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $deploy_configs->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $deploy_configs->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
