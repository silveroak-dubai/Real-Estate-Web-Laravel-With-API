@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')

@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 card-title">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                            type="button" role="tab" aria-controls="password" aria-selected="false">Password</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form id="profile-form" class="mt-3" enctype="multipart/form-data">
                            @csrf
                            <x-form.inputbox labelName="Full Name" name="name" required="required" placeholder="Enter full name" value="{{ $user->name ?? '' }}"/>
                            <x-form.inputbox type="email" labelName="Email" name="email" required="required" placeholder="Enter email" value="{{ $user->email ?? '' }}"/>
                            <x-form.inputbox type="number" labelName="Mobile No" name="mobile_no" required="required" placeholder="Enter mobile number" value="{{ $user->mobile_no ?? '' }}"/>
                            <x-form.selectbox labelName="Gender" name="gender" required="required">
                                <option value="">Select Gender</option>
                                @foreach (GENDER as $key=>$value)
                                <option value="{{ $key }}" {{ $user->gender == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </x-form.selectbox>
                            <x-form.inputbox type="file" labelName="Image" name="image"/>
                            <input type="hidden" name="old_image" id="old_image" value="{{ $user->image ?? '' }}">
                        </form>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-primary rounded-0" onclick="save_form('profile-form')" id="save-btn"><span></span> Save Changes</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <form id="password-form" class="mt-3">
                            @csrf
                            <x-form.inputbox type="password" labelName="Current Password" name="current_password" required="required" placeholder="Enter password"/>
                            <x-form.inputbox type="password" labelName="New Password" name="password" required="required" placeholder="Enter password"/>
                            <x-form.inputbox type="password" labelName="Confirm Password" name="password_confirmation" required="required" placeholder="Enter confirm password"/>
                        </form>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-primary rounded-0" onclick="save_form('password-form')" id="save-btn"><span></span> Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function save_form(form_id){
            var form = document.getElementById(form_id);
            var formData = new FormData(form);
            var url;
            if(form_id == 'profile-form'){
                url = "{{ route('app.profile.update') }}";
            }else if(form_id == 'password-form'){
                url = "{{ route('app.password.update') }}";
            }

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function(){
                    $('#'+form_id+' #save-btn span').addClass('spinner-border spinner-border-sm text-light');
                },
                complete: function(){
                    $('#'+form_id+' #save-btn span').removeClass('spinner-border spinner-border-sm text-light');
                },
                success: function (response) {
                    $('#'+form_id).find('.error').remove();
                    $('#'+form_id).find('.is-invalid').removeClass('is-invalid');
                    if (response.status == false) {
                        $.each(response.errors,function(key,value){
                            $('#'+form_id+' #'+key).addClass('is-invalid');
                            $('#'+form_id+' #'+key).parent().append('<small class="text-danger error">'+value+'</small>');
                        });
                    }else{
                        notification(response.status,response.message);
                        if (response.status == 'success') {
                            setInterval(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                }
            });
        }
    </script>
@endpush
