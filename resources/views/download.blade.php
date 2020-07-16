@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div style="width: 100%; max-width: 990px; display: inline-block; font-size: 16px">
            <h1>
                File Download
            </h1>

            <p>
                Your download will start momentarily. If it does not, click <a href="{{ route('download.file', $fileid) }}">here</a> to start it.
            </p>

            <p style="font-size: 16px">
                <a href="/" class="btn btn-primary"><i class="fas fa-chevron-circle-left"></i> Back</a>
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="application/javascript">
        window.onload = function () {
            setTimeout(function () {
                window.location = "{{ route('download.file', $fileid) }}";
            }, 2000);
        }
    </script>
@endsection
