    @extends('../templates/auth')

    @section('title', '403')
    
    @section('container')
      
    <div class="container-fluid">
        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto" data-text="403">403</div>
            <p class="lead text-gray-800 mb-5">Page Forbidden</p>
            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
            <a href="{{ url('/user') }}">&larr; Back to User</a>
        </div>
    </div>
    @endsection