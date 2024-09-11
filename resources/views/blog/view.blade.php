@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
<style>


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

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>

</script>
@endpush
