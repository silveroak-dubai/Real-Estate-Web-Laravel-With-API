@extends('layouts.app')
@section('title',$siteTitle)
@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    .team-ordering {
        padding-left: 0;
        list-style: none;
    }
    .team-ordering li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        padding: 5px 10px;
        font-size: 13px;
        font-weight: 400;
        border-radius: 3px;
    }
    .team-ordering li:hover{
        cursor: move;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <ul class="team-ordering mb-0" id="team-ordering">
                        @forelse ($data->ourTeams as $team)
                        <li data-id="{{ $team->id }}">
                            <p class="mb-0">{{ $team->full_name }} <span class="bg-success rounded-1 px-2">{{ $team->position }}</span></p>
                            <i class="fa fa-arrows"></i>
                        </li>
                        @empty

                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/jquery-ui.min.js"></script>
<script>
    $("#team-ordering").sortable({
        update: function(event, ui) {
            var order = [];
            $('#team-ordering > li').each(function(index, element) {
                order.push($(element).data('id'));
            });

            $.ajax({
                url: '{{ route("app.departments.ordering") }}',
                method: 'POST',
                data: {
                    order: order,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    notification(response.status,response.message);
                    if(response.status == 'success') {
                        setInterval(() => {
                            window.location.reload();
                        }, 1000);
                    }
                }
            });
        }
    });

    $("#status-ordering").disableSelection();
</script>
@endpush
