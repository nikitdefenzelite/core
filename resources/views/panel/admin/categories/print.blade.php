
@extends('layouts.empty') 
@section('title', 'Article')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table id="categoryTable" class="table">
                    <thead>
                        <tr>
                            <th class="col-1"> {{ __('iD') }}</th>
                            <th class="col-2">{{ __('title') }}</th>
                            <th class="col-3">{{ __('created') }} At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(@$categories->count() > 0)
                            @foreach(@$categories as $category)
                                <tr>
                                    <td class="col-1">{{ @$category->getPrefix() }}</td>
                                    <td class="col-2">{{ ucwords(str_replace('_',' ',@$category->name)) ?? '--' }}</td>
                                    <td class="col-3">{{ @$category->created_at ?? '--' }}</td>
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