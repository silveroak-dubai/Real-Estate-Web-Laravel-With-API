@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
<style>
    #permission {
        margin:0 !important;
        padding:0 !important;
        list-style:none !important;
    }

</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>Full Name:</td>
                            <td>{{ $view->name }}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{ $view->email }}</td>
                        </tr>
                        <tr>
                            <td>Mobile No:</td>
                            <td>{{ $view->mobile_no }}</td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td>{{ GENDER[$view->gender] }}</td>
                        </tr>
                        <tr>
                            <td>Is Active:</td>
                            <td>{!! STATUS_LABEL[$view->is_active] !!}</td>
                        </tr>
                        <tr>
                            <td>Created By:</td>
                            <td>{{ $view->created_by }}</td>
                        </tr>
                        <tr>
                            <td>Created At:</td>
                            <td>{{ dateFormat($view->created_at) }}</td>
                        </tr>
                    </table>

                    @if ($view->permissions->isNotEmpty())
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Module</th>
                                <th>Permission</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($modules as $module)
                            <tr>
                                <td>{{ $module->name }}</td>
                                <td>
                                    <ul id="permission">
                                        @forelse ($module->permissions as $permission)
                                            <li>
                                                @foreach ($view->permissions as $r_permission)
                                                    {{ $r_permission->id == $permission->id ? $permission->name : '' }}
                                                @endforeach
                                            </li>
                                        @empty

                                        @endforelse
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>

</script>
@endpush
