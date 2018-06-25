@extends('layouts.app')

@section('content')
    <div class="card card--section">
        <div class="card-header">Propose a new shift exchange</div>
        <div class="card-body">
            <form method="post" action="{{ route('exchanges.store', $enrollment->id) }}">
                {{ csrf_field() }}
                

                <div id="steps-left">
                    <h3>Exchange Method</h3>
                    <section style="height:100%;">
                        <center  style="margin: auto; height:50%">
                            <a id="shift-exchange-btn" class="btn btn-outline-secondary btn-sm">Shift</a>
                            <a id="student-exchange-btn" class="btn btn-outline-secondary btn-sm">Student</a>
                        </center>
                    </section>
                    <h3>Pick your destiny</h3>
                    <section>
                        <div id="shift-exchange-form" style="display:none">
                            Banco de Trocas
                        </div>
                        <div id="student-exchange-form"style="display:none">
                                {{-- From enrollment--}}
                        <div class="form-group">
                            <label>From enrollment</label>
                            <input type="text"
                            class="form-control {{ $errors->has('from_enrollment_id') ? 'is-invalid' : '' }}"
                            value="{{ $enrollment->present()->inlineToString() }}"
                            required readonly>
                            <div class="form-text text-danger">{{ $errors->first('from_enrollment_id') }}</div>
                        </div>

                        {{-- To enrollment--}}
                        <div class="form-group">
                            <label>To enrollment</label>
                            <enrollment-select name="to_enrollment_id" :options="{{ $matchingEnrollments }}"></enrollment-select>
                            <div class="form-text text-danger">{{ $errors->first('to_enrollment_id') }}</div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary">Request exchange</button>
                        </div>
                    </section>

                    <h3>Confirmation</h3>
                    <section>
                        <p>The next and previous buttons help you to navigate through your content.</p>
                    </section>
                </div>
                


                
            </form>
        </div>
    </div>
    
@endsection
