@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    @if (session('status'))
        <div class="card green darken-1">
            <div class="card-content white-text">
                {{ session('status') }}
            </div>
        </div>
    @endif
    <br>
    <div class="card">
        <div class="card-content">

            <span class="card-title">Your creations</span>
            <hr>

            <table class="responsive-table">
                <thead>
                  <tr>
                      <th>Name</th>
                      <th>Date</th>
                      <th></th>
                      <th></th>
                  </tr>
                </thead>

                <tbody>
                    @foreach ($routes as $route)
                        <tr>
                            <td>{{ $route->name }}</td>
                            <td>{{ $route->created_at }}</td>
                            <td><a href="{{ route('routes.edit', $route->id) }}" class="waves-effect waves-light  btn-small right">Edit<i class="material-icons right">edit</i></a></td>
                            <td><a href="{{ route('routes.copy', $route->id) }}" class="copy-route waves-effect waves-light  btn-small right">Duplicate<i class="material-icons right">control_point_duplicate</i></a></td>
                            <td><a href="{{ route('routes.destroy', $route->id) }}" class="delete-route waves-effect waves-light  btn-small orange right">Delete<i class="material-icons right">delete</i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
      </div>
    </div>
    <div class="center">{{ $routes->links() }}</div>

</div>
@endsection

@section('script')

    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $(document).ready(function(){
            if(sessionStorage.getItem('copy')) {
                sessionStorage.removeItem('copy');
                $('tbody tr:first-of-type').addClass('indigo lighten-5');
            }
            $('.delete-route').click(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'DELETE',
                    url: $(this).attr('href')
                }).done(function() {
                    location.reload();
                });
            });
            $('.copy-route').click(function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: $(this).attr('href')
                }).done(function() {
                    sessionStorage.setItem('copy', true)
                    window.location = window.location.pathname;
                    //location.reload();
                });
            });
        });
    </script>

@endsection
