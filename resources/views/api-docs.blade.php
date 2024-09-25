<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>API Documentation</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">API Documentation</h1>
        <div id="accordion"> <!-- Parent container for collapse -->
            @foreach ($apiDocs['endpoints'] as $endpoint)
                <div class="card mb-2">
                    <div class="card-header py-1 px-3" id="heading-{{ $loop->index }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link btn-sm w-100 d-flex align-items-center justify-content-between shadow-none" data-toggle="collapse" data-target="#collapse-{{ $loop->index }}" aria-expanded="false" aria-controls="collapse-{{ $loop->index }}">
                                <span class="toggle-text">{{ strtoupper($endpoint['method']) }} {{ $endpoint['endpoint'] }}</span>
                                <i class="fas fa-plus" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse-{{ $loop->index }}" class="collapse" aria-labelledby="heading-{{ $loop->index }}" data-parent="#accordion">
                        <div class="card-body">
                            <p><strong>Description:</strong> {{ $endpoint['description'] }}</p>

                            @if (!empty($endpoint['parameters']))
                                <h6>Parameters:</h6>
                                <ul>
                                    @foreach ($endpoint['parameters'] as $param)
                                        <li>
                                            <strong>{{ $param['name'] }}</strong> ({{ $param['type'] }})
                                            @if ($param['required']) <em>(required)</em> @endif
                                            - {{ $param['description'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <h6>Response:</h6>
                            <p>Status Code: {{ $endpoint['response']['status_code'] }}</p>
                            <pre>{{ json_encode($endpoint['response']['example'], JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Change the icon on collapse toggle
            $('.collapse').on('show.bs.collapse', function() {
                $(this).parent().find('button i').removeClass('fa-plus').addClass('fa-minus');
            }).on('hide.bs.collapse', function() {
                $(this).parent().find('button i').removeClass('fa-minus').addClass('fa-plus');
            });
        });
    </script>
</body>
</html>
