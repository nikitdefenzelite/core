@extends('layouts.empty') 
@section('title', 'Article')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table id="categoryTypeTable" class="table">
                    <thead>
                        <tr>
                            <th class="col-1">{{ __('iD') }}</th>
                            <th class="col-2">{{ __('title') }}</th>
                            <th class="col-3">{{ __('created') }} At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(@$categoryTypes->count() > 0)
                            @foreach(@$categoryTypes as $categoryType)
                                <tr>
                                    <td class="col-1">{{ @$categoryType->getPrefix() }}</td>
                                    <td class="col-2">{{ ucwords(str_replace('_',' ',@$categoryType->name)) ?? '--' }}</td>
                                    <td class="col-3">{{ (@$categoryType->created_at ?? '--') }}</td>
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
@endsection