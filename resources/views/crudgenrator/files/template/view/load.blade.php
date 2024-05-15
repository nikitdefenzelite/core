<div class="card-body">
    <div class="table-controller mb-2">
        <div class="d-flex justify-content-between">
            <div class="mr-3">
                <label for="">Show
                    <select name="length" class="length-input" id="length">
                        {{ $data['atsign'] }}foreach(tableLimits() as $limit)
                        <option value="{{ $data['curlstart'] }} $limit}}"{{ $data['curlstart'] }} {{ $indexvariable }}->
                            perPage() == @$limit ? 'selected' : '' }}>{{ $data['curlstart'] }} $limit }}</option>
                        {{ $data['atsign'] }}endforeach
                    </select>
                    entries
                </label>
            </div>
            <div>
                @if (!isset($data['excel_btn']))
                    {{ commentOutStart() }}
                @endif
                <button type="button" id="export_button" class="btn btn-light btn-sm">Excel</button>
                @if (!isset($data['excel_btn']))
                    {{ commentOutEnd() }}
                @endif
                @if (!isset($data['print_btn']))
                    {{ commentOutStart() }}
                @endif
                <a href="javascript:void(0);" id="print"
                    data-url="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.print') }}"
                    data-rows="{{ $data['curlstart'] }}json_encode({{ $indexvariable }}) }}"
                    class="btn btn-light btn-sm">Print</a>
                @if (!isset($data['print_btn']))
                    {{ commentOutEnd() }}
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div>
                <input type="text" name="search" class="form-control mr-2 w-unset" placeholder="Search"
                    id="search" value="{{ $data['curlstart'] }}request()->get('search') }}">
            </div>
            <button type="button" class="off-canvas btn btn-outline-light text-muted btn-icon"><i
                    class="fa fa-filter fa-lg"></i>
            </button>
        </div>
    </div>
    <div class="table-responsive">
        {{ $data['atsign'] }}include('{{ $data['dotviewpath'] }}{{ $data['view_name'] }}.table')
    </div>
</div>
<div class="card-footer">
    <div class="row">
        <div class="col-lg-8">
            <div class="pagination mobile-justify-center">
                {{ $data['curlstart'] }} {{ $indexvariable }}->appends(request()->except('page'))->links() }}
            </div>
        </div>
        <div class="col-lg-4 mobile-mt-20">
            {{ $data['atsign'] }}if({{ $indexvariable }}->lastPage() > 1)
            <label class="d-flex justify-content-end mobile-justify-center" for="">
                <div class="mr-2 pt-2">
                    Jump To:
                </div>
                <input type="number" class="w-25 form-control" id="jumpTo" name="page"
                    value="{{ $data['curlstart'] }} {{ $indexvariable }}->currentPage() ?? ''}}">
            </label>
            {{ $data['atsign'] }}endif
        </div>
    </div>
</div>
