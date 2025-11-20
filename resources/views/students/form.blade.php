@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@props(['student' => null, 'departments', 'countries'])

{{-- CSRF for Axios / jQuery --}}
@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

<form method="POST" enctype="multipart/form-data"
      action="{{ $student ? route('students.update', $student) : route('students.store') }}">
    @csrf
    @if($student)
        @method('PUT')
    @endif

<div class="row">

    <div class="col-md-6 mb-3">
        <label>First Name</label>
        <input type="text" name="first_name"
               value="{{ old('first_name', $student->first_name ?? '') }}"
               class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Last Name</label>
        <input type="text" name="last_name"
               value="{{ old('last_name', $student->last_name ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Profile Photo</label>
        <input type="file" name="profile_photo" class="form-control">

        @if(!empty($student->profile_photo))
            <img src="{{ asset('storage/' . $student->profile_photo) }}"
                 width="80" class="mt-2">
        @endif
    </div>

    <div class="col-md-3 mb-3">
        <label>Age</label>
        <input type="number" name="age" value="{{ old('age', $student->age ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-3 mb-3">
        <label>DOB</label>
        <input type="date" name="dob" value="{{ old('dob', $student->dob ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="email"
               value="{{ old('email', $student->email ?? '') }}"
               class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Phone</label>
        <input type="text" name="phone"
               value="{{ old('phone', $student->phone ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Pincode</label>
        <input type="text" name="pincode"
               value="{{ old('pincode', $student->pincode ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Department</label>
        <select name="department_id" id="department_id" class="form-select" required>
            <option value="">-- Select Department --</option>

            @foreach($departments as $d)
                <option value="{{ $d->id }}"
                        @selected(old('department_id', $student->department_id ?? '') == $d->id)>
                    {{ $d->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label>Courses</label>
        <select name="courses[]" id="courses" class="form-select" disabled>
            <option value="">-- Select Courses --</option>
        </select>
    </div>

    {{-- Location fields --}}
    <div class="col-md-4 mb-3">
        <label>Country</label>
        <select name="country_id" id="country_id" class="form-select">
            <option value="">-- Select Country --</option>
            @foreach($countries as $c)
                <option value="{{ $c->id }}"
                        @selected(old('country_id', $student->country_id ?? '') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label>State</label>
        <select name="state_id" id="state_id" class="form-select" disabled>
            <option value="">-- Select State --</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label>City</label>
        <select name="city_id" id="city_id" class="form-select" disabled>
            <option value="">-- Select City --</option>
        </select>
    </div>

</div>

<button class="btn btn-success">{{ $student ? 'Update' : 'Create' }}</button>
<a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>

</form>

@push('scripts')

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function () {

    /* ---------------------------
       CSRF for AJAX
    -----------------------------*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* ---------------------------
       Helpers
    -----------------------------*/
    const routes = {
        deptCourses: (id) => "{{ url('departments') }}/" + id + "/courses",
        countryStates: (id) => "{{ url('countries') }}/" + id + "/states",
        stateCities: (id) => "{{ url('states') }}/" + id + "/cities",
    };

    function clearAndDisable(selector, placeholder) {
        $(selector)
            .html(`<option value="">${placeholder}</option>`)
            .prop("disabled", true);
    }

    /* ---------------------------
       Load Courses
    -----------------------------*/
    function loadCourses(deptId, selected = []) {
        if (!deptId) {
            clearAndDisable("#courses", "-- Select Courses --");
            return;
        }

        axios.get(routes.deptCourses(deptId))
            .then(function (response) {
                $("#courses").html(`<option value="">-- Select Courses --</option>`);

                response.data.forEach(course => {
                    const isSelected = selected.map(String).includes(String(course.id)) ? 'selected' : '';
                    $("#courses").append(`<option value="${course.id}" ${isSelected}>${course.name}</option>`);
                });

                $("#courses").prop("disabled", false);
            })
            .catch(function (error) {
                console.error("Error loading courses:", error.response?.status, error.response?.data);
            });
    }

    /* ---------------------------
       Load States
    -----------------------------*/
    function loadStates(countryId, selected = []) {
        if (!countryId) {
            clearAndDisable("#state_id", "-- Select State --");
            clearAndDisable("#city_id", "-- Select City --");
            return;
        }

        axios.get(routes.countryStates(countryId))
            .then(function (response) {
                $("#state_id").html(`<option value="">-- Select State --</option>`);

                response.data.forEach(state => {
                    const isSelected = selected.map(String).includes(String(state.id)) ? 'selected' : '';
                    $("#state_id").append(`<option value="${state.id}" ${isSelected}>${state.name}</option>`);
                });

                $("#state_id").prop("disabled", false);
            })
            .catch(function (error) {
                console.error("Error loading states:", error.response?.status, error.response?.data);
            });
    }

    /* ---------------------------
       Load Cities
    -----------------------------*/
    function loadCities(stateId, selected = []) {
        if (!stateId) {
            clearAndDisable("#city_id", "-- Select City --");
            return;
        }

        axios.get(routes.stateCities(stateId))
            .then(function (response) {
                $("#city_id").html(`<option value="">-- Select City --</option>`);

                response.data.forEach(city => {
                    const isSelected = selected.map(String).includes(String(city.id)) ? 'selected' : '';
                    $("#city_id").append(`<option value="${city.id}" ${isSelected}>${city.name}</option>`);
                });

                $("#city_id").prop("disabled", false);
            })
            .catch(function (error) {
                console.error("Error loading cities:", error.response?.status, error.response?.data);
            });
    }

    /* ---------------------------
       Event Listeners
    -----------------------------*/
    $("#department_id").on("change", function () {
        loadCourses($(this).val(), []);
    });

    $("#country_id").on("change", function () {
        loadStates($(this).val(), []);
    });

    $("#state_id").on("change", function () {
        loadCities($(this).val(), []);
    });

    /* ---------------------------
       EDIT MODE preload
    -----------------------------*/
    @if(isset($student))

        let selectedCourses = @json($student->courses->pluck('id'));

        let preCountry = "{{ old('country_id', $student->country_id ?? '') }}";
        let preState   = "{{ old('state_id', $student->state_id ?? '') }}";
        let preCity    = "{{ old('city_id', $student->city_id ?? '') }}";

        if ($("#department_id").val()) {
            loadCourses($("#department_id").val(), selectedCourses);
        }

        if (preCountry) {
            loadStates(preCountry, [preState]);

            setTimeout(() => {
                if (preState) {
                    loadCities(preState, [preCity]);
                }
            }, 500);
        }

    @endif

});
</script>
@endpush
