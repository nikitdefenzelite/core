{{ $data['atsign'] }}extends('layouts.empty')
{{ $data['atsign'] }}section('title', '{{ $indexheading }}')
{{ $data['atsign'] }}section('content')
{{ $data['atsign'] }}php
/**
* {{ $heading }}
*
* @category ZStarter
*
* @ref zCURD
* @author Defenzelite <hq@defenzelite.com>
    * @license https://www.defenzelite.com Defenzelite Private Limited
    * @version <zStarter: 1.1.0>
        * @link https://www.defenzelite.com
        */
        {{ $data['atsign'] }}endphp


        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="table-responsive">
                            {{ $data['atsign'] }}include('{{ $data['dotviewpath'] }}{{ $data['view_name'] }}.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $data['atsign'] }}endsection
