@extends('backend.layouts.empty') 
@section('title', 'Deploy Configs')
@section('content')
@php
/**
 * Deploy Config 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
@endphp
   

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">                     
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>                                      
                                    <th>Name</th>
                                    <th>Project Register  </th>
                                    <th>Status</th>
                                    <th>Payload</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($deploy_configs->count() > 0)
                                    @foreach($deploy_configs as  $deploy_config)
                                        <tr>
                                            <td>{{$deploy_config['name'] }}</td>
                                                 <td>{{fetchFirst('App\Models\ProjectRegister',$deploy_config['project_register_id'],'name','--')}}</td>
                                             <td>{{$deploy_config['status'] }}</td>
                                             <td>{{$deploy_config['payload'] }}</td>
                                                 
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
            </div>
        </div>
    </div>
@endsection
