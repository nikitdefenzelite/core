@extends('backend.layouts.main')
@section('title', 'Deploy Configs')
@section('content')
@php
/**
* Deploy Config
*
* @category  zStarter  v1
*
* @ref  zCURD
* @author  Defenzelite <hq@defenzelite.com>
    * @license  https://www.defenzelite.com Defenzelite Private Limited
    * @version  <zStarter: 1.1.0>
        * @link  https://www.defenzelite.com
        */
        $breadcrumb_arr = [
        ['name'=>'Deploy Configs', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
        @endphp
        <!-- push external head elements to head -->
        @push('head')
        @endpush

        <div class="container-fluid">


            <form action="{{ route('panel.deploy_configs.index') }}"
                method="GET" id="TableForm">
                <div class="row">
                    <!-- start message area-->
                    <!-- end message area-->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h3>Deploy Configs</h3>
                                <div class="d-flex justicy-content-right">
                                    <div class="form-group mb-0 mr-2">
                                        <span>From</span>
                                        <label for=""><input type="date" name="from" class="form-control"
                                                value="{{request()->get('from')}}"></label>
                                    </div>
                                    <div class="form-group mb-0 mr-2">
                                        <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control"
                                                value="{{request()->get('to')}}"></label>
                                    </div>
                                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning"
                                        title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    <a href="javascript:void(0);" id="reset"
                                        data-url="{{ route('panel.deploy_configs.index') }}"
                                        class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i
                                            class="fa fa-redo" aria-hidden="true"></i></a>
                                    <a href="{{ route('panel.deploy_configs.create') }}"
                                        class="btn btn-icon btn-sm btn-outline-primary"
                                        title="Add New Deploy Config"><i class="fa fa-plus"
                                            aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div id="ajax-container">
                                @include('panel.deploy_configs.load')
                            </div>
                        </div>
                    </div>
                </div>
                <form>
        </div>
        <!-- push external js -->
        @push('script')
        <script src="{{ asset('backend/js/index-page.js') }}"></script>
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>

            function html_table_to_excel(type)
            {
            var table_core = $("#table").clone();
            var clonedTable = $("#table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#table").html(clonedTable.html());
            var data = document.getElementById('table');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'DeployConfigFile.' + type);
            $("#table").html(table_core.html());

            }

            $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
            })


            $('#reset').click(function(){
            var url = $(this).data('url');
            fetchData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
            // $('#fieldId').select2('val',""); // if you use any select2 in filtering uncomment this code
            // $('#fieldId').trigger('change'); // if you use any select2 in filtering uncomment this code
            });


            </script>
            @endpush
            @endsection
