
@extends('layouts.account')

@section('content')

  <div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-6">
				<h3 class="text-default">
					{{ _t('History') }}
				</h3>
			</div>
		</div>
	</div>

	<div class="card-body">
		@if ($message = Session::get('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ $message }}
		</div>
		@endif

    <?php
        $_academic = _t('Academic Year');
        $_course = _t('Course');
        $_subject = _t('Subject');
        $_select = _t('please_select_one');
        $_start_date = _t('Start Date');
        $_end_date = _t('End Date');
        $_date_create = _t('Date Create');
    ?>

    <!-- blog search here -->

		<div class="row wrapper-row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="width-20px">{{ _t('No') }}</th>
								<th>@sortablelink('academic_year_id',_t('Academic Year'))</th>
								<th>@sortablelink('course_id',_t('Course'))</th>
                				<th>@sortablelink('class_id',_t('Class'))</th>
								<th>{{ _t('Subject') }}</th>
								<th>@sortablelink('pay_start_date',_t('Start Date'))</th>
								<th>@sortablelink('pay_end_date',_t('End Date'))</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							@foreach ($data as $key => $item)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $item->academic_year->name }}</td>
								<td>{{ $item->course->name }}</td>
                				<td>{{ $item->clazz->name }}</td>
				                <td>
				                  @foreach ($item->student_register_subjects as $entity)
				                    <a href="{{ route('courses-video.subject_videos', [$entity->id]) }}">
				                    	<span class="btn btn-primary btn-sm">{{ $entity->subject->name }}</span>
				                   	</a>
				                  @endforeach
				                </td>
				                <td>{{ $item->pay_start_date }}</td>
				                <td>{{ $item->pay_end_date }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

			</div>

		</div>

   </div>
</div>
@endsection
