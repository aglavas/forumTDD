@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a thread</div>
                    <div class="panel-body">
                        <form method="POST" action="/threads">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">
                                    Title:
                                </label>
                                <input name="title" id="title" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="body">
                                    Body:
                                </label>
                                <textarea name="body" id="body" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-default">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
