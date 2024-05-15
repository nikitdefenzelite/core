@extends('layouts.app')

@section('meta_data')
    @php
		$meta_title =  @$metas->title ?? 'Home';
		$meta_description = @$metas->description ?? '';
		$meta_keywords = @$metas->keyword ?? '';
		$meta_motto = @$app_settings['site_motto'] ?? '';
		$meta_abstract = @$app_settings['site_motto'] ?? '';
		$meta_author_name = @$app_settings['app_name'] ?? 'Defenzelite';
		$meta_author_email = @$app_settings['frontend_footer_email'] ?? 'dev@defenzelite.com';
		$meta_reply_to = @$app_settings['frontend_footer_email'] ?? 'dev@defenzelite.com';
		$meta_img = ' ';
	@endphp
@endsection

@section('content')
    <div class="container">
        <form method="post" action="{{ route('submit') }}" id="projectForm">
            @csrf
            <div class="form-group">
                <label for="ftpUrl">Project Name</label>
                <select class="form-control project_id" name="project_id" required>
                    <option value="" readonly>Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project['id'] }}">{{ $project['name'] }}</option>
                    @endforeach
                </select>
            </div>
          
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection


