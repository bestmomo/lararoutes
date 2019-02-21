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

            <span class="card-title">Trashed</span>
            <hr>

            <table class="responsive-table">
                <thead>
                  <tr>
                      <th>Name</th>
                      <th>Date deleted</th>
                      <th></th>
                      <th></th>
                  </tr>
                </thead>

                <tbody>
                    @foreach ($routes as $route)
                        <tr>
                            <td>{{ $route->name }}</td>
                            <td>{{ $route->deleted_at }}</td>
                            <td><a href="{{ route('routes.restore', $route->id) }}" class="restore-route waves-effect waves-light  btn-small green right">Restore<i class="material-icons right">reply</i></a></td>
                            <td><a href="{{ route('routes.delete', $route->id) }}" class="delete-route waves-effect waves-light  btn-small red right">Delete<i class="material-icons right">delete</i></a></td>
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
            $('.restore-route').click(function(e) {
                e.preventDefault();
                $.ajax({
                    method: "PUT",
                    url: $(this).attr('href')
                }).done(function() {
                    location.reload();
                });
            });
            $('.delete-route').click(function(e) {
                e.preventDefault();
                $.ajax({
                    method: "DELETE",
                    url: $(this).attr('href')
                }).done(function() {
                    location.reload();
                });
            });
        });
    </script>

@endsection
