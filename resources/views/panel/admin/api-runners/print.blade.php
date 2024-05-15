@extends('layouts.empty')
@section('title', 'Api Runners')
@section('content')
@php
/**
* Api Runner
*
* @category ZStarter
*
* @ref zCURD
* @author Defenzelite <hq@defenzelite.com>
    * @license https://www.defenzelite.com Defenzelite Private Limited
    * @version <zStarter: 1.1.0>
        * @link https://www.defenzelite.com
        */
        @endphp


        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="table-responsive">
                            @include('panel.admin.api-runners.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
