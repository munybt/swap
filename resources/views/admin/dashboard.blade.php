@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>List of courses</strong></div>
                    <table class="card-table table">
                        <tbody>
                            @foreach ($courses as $year => $courses)
                                <tr>
                                    <th colspan="3" class="table-active">
                                        {{ $year }} year
                                    </th>
                                </tr>
                                <tr>
                                    <th>Semester</th>
                                    <th>Course</th>
                                    <th>Enrollments</th>
                                </tr>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->present()->getOrdinalSemester() }}</td>
                                        <td><a href="{{ route('students.index', $course->id) }}">{{ $course->name }}</a></td>
                                        <td>{{ $course->enrollments_count }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection